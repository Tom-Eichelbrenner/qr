<?php

namespace App\Service;

use Knp\Snappy\Pdf;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


class PDFCreator
{

    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var Pdf
     */
    protected $snappy;

    /**
     * @var string
     */
    private $projectDir;


    public function __construct(Environment $twig, Pdf $snappy, string $projectDir)
    {
        $this->twig = $twig;
        $this->snappy = $snappy;
        $this->projectDir = $projectDir;
    }

    private function pdfTemplateExists($template): bool
    {
        return $this->twig->getLoader()->exists($template);
    }

    /**
     * @param $template
     * @param $data
     * @param $filename
     *
     * @return FileTo64
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function generatePdf($template, $data, $filename): FileTo64
    {
        if (!is_dir("$this->projectDir/var/files")){
            mkdir("$this->projectDir/var/files");
        }
        $filename = "$this->projectDir/var/files/$filename";
        if (!$this->pdfTemplateExists($template)) {
            throw new LoaderError('Le template n\'existe pas');
        }
        $html = $this->twig->render($template,
            [
                'data' => $data
            ]);
        $this->snappy->generateFromHtml($html, $filename);
        return new FileTo64($filename);
    }

}