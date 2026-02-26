<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    private $httpClient;
    private $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler; 
    }

    public function buscar(string $url): array
    {
        $resposta = $this->httpClient->request('GET', $url); //pega os dados do site que vc colocar com metodo GET

        $html = $resposta->getBody(); //pega o html 
        $this->crawler->addHtmlContent((string) $html);

        $elementosCursos = $this->crawler->filter(selector:'span.card-curso__nome'); //filtra a informacao que queremos com base no inspecionar do site 
        $cursos = [];

        foreach ($elementosCursos as $elemento) {
            $cursos[] = $elemento->textContent;
        }

        return $cursos;
    }
}