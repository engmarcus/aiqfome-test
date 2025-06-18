<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;

/**
 * Class HttpClient
 *
 * Esta classe fornece métodos para realizar requisições HTTP utilizando o cliente HTTP do Laravel.
 * Inclui suporte para métodos GET, POST, PUT e DELETE, além de configuração de cabeçalhos e opções de SSL.
 *
 * @package App\Support
 */
abstract class HttpClient
{
    /**
     * @var array Cabeçalhos padrão para as requisições HTTP.
     */
    protected $defaultHeaders;

    /**
     * @var string URL base para as requisições HTTP.
     */
    protected $baseUrl;

    /**
     * Configura o cliente HTTP com URL base e cabeçalhos opcionais.
     *
     * @param string $baseUrl URL base para as requisições HTTP.
     * @param array $headers Cabeçalhos HTTP padrão a serem incluídos em todas as requisições.
     * @return void
     */
    public function config(string $baseUrl, array $headers = [])
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->defaultHeaders = $headers;
    }

    /**
     * Realiza uma requisição GET.
     *
     * @param string $url URL do endpoint para a requisição GET.
     * @param array $headers Cabeçalhos HTTP adicionais para a requisição.
     * @return array Resultado da requisição contendo o código de status, dados e mensagem de erro (se houver).
     */
    public function get(string $url, $headers = [], array $cookies = [], string $cookiesDomain = '', bool $disableSSL = false)
    {
        return $this->sendRequest('GET', $url, null, $headers, $cookies, $cookiesDomain, $disableSSL);
    }


    /**
     * Realiza uma requisição POST.
     *
     * @param string $url URL do endpoint para a requisição POST.
     * @param array $data Dados a serem enviados no corpo da requisição.
     * @param array $headers Cabeçalhos HTTP adicionais para a requisição.
     * @return array Resultado da requisição contendo o código de status, dados e mensagem de erro (se houver).
     */
    public function post(string $url, array $data, $headers = [], array $cookies = [], string $cookiesDomain = '')
    {
        return $this->sendRequest('POST', $url, $data, $headers, $cookies, $cookiesDomain);
    }

    /**
     * Realiza uma requisição PUT.
     *
     * @param string $url URL do endpoint para a requisição PUT.
     * @param array $data Dados a serem enviados no corpo da requisição.
     * @param array $headers Cabeçalhos HTTP adicionais para a requisição.
     * @return array Resultado da requisição contendo o código de status, dados e mensagem de erro (se houver).
     */
    public function put(string $url, array $data, $headers = [], array $cookies = [], string $cookiesDomain = '',$disableSSL = false)
    {
        return $this->sendRequest('PUT', $url, $data, $headers, $cookies, $cookiesDomain, $disableSSL);
    }

    /**
     * Realiza uma requisição DELETE.
     *
     * @param string $url URL do endpoint para a requisição DELETE.
     * @param array $headers Cabeçalhos HTTP adicionais para a requisição.
     * @return array Resultado da requisição contendo o código de status, dados e mensagem de erro (se houver).
     */
    public function delete(string $url, array $headers = [], array $cookies = [], string $cookiesDomain = '')
    {
        return $this->sendRequest('DELETE', $url, null, $headers, $cookies, $cookiesDomain);
    }

    /**
     * Configura e envia uma requisição HTTP.
     *
     * @param string $method Método HTTP a ser utilizado (GET, POST, PUT, DELETE).
     * @param string $endpoint URL do endpoint para a requisição.
     * @param array|null $data Dados a serem enviados no corpo da requisição (opcional).
     * @param array $headers Cabeçalhos HTTP adicionais para a requisição.
     * @return array Resultado da requisição contendo o código de status, dados e mensagem de erro (se houver).
     */
    protected function sendRequest(string $method, string $endpoint, array $data = null, array $headers = [], $cookies = [], $cookiesDomain = '', bool $disableSSL = false)
    {
        $url = $this->baseUrl . $endpoint;

        $mergedHeaders = array_merge($this->defaultHeaders, $headers);

        $request = Http::withHeaders($mergedHeaders);


        if ($disableSSL) {
            $request = $request->withoutVerifying();
        }

        if (!empty($cookies)) {
            $request = $request->withCookies($cookies, $cookiesDomain);
        }

        if ($this->shouldSendAsForm($mergedHeaders)) {
            $response = $request->asForm()->$method($url, $data);
        } else {
            $response = $request->$method($url, $data);
        }

        if ($response->failed()) {
            return [
                'statusCode' => $response->status(),
                'data' => $this->parseResponseBody($response->body()),
                'message' => $response->body(),
            ];
        }

        return [
            'statusCode' => $response->status(),
            'data' => $this->parseResponseBody($response->body()),
            'message' => null,
        ];
    }

    /**
     * Adiciona ou atualiza cabeçalhos padrão.
     *
     * @param array $headers Cabeçalhos a serem adicionados ou atualizados.
     * @return void
     */
    public function addDefaultHeaders(array $headers)
    {
        $this->defaultHeaders = array_merge($this->defaultHeaders, $headers);
    }

    /**
     * Remove um cabeçalho padrão específico.
     *
     * @param string $header Nome do cabeçalho a ser removido.
     * @return void
     */
    public function removeDefaultHeader(string $header)
    {
        if (isset($this->defaultHeaders[$header])) {
            unset($this->defaultHeaders[$header]);
        }
    }

    public function getDefaultHeaders()
    {
        return $this->defaultHeaders;
    }

    /**
     * Valida e converte os dados para JSON se necessário.
     *
     * @param array $data Dados a serem enviados.
     * @return array|string Dados no formato apropriado.
     */
    protected function validateJson(array $data)
    {
        $json = json_encode($data);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $json;
        }

        return $data;
    }

    /**
     * Faz o parse do corpo da resposta, esperando JSON se possível.
     *
     * @param string $body Corpo da resposta.
     * @return array|string Dados decodificados ou o corpo como string.
     */
    protected function parseResponseBody(string $body)
    {
        $decoded = json_decode($body, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }

        return $body;
    }

    /**
     * Verifica se os dados devem ser enviados como application/x-www-form-urlencoded.
     *
     * @param array $headers Cabeçalhos HTTP da requisição.
     * @return bool Retorna true se os dados devem ser enviados como form-urlencoded.
     */
    protected function shouldSendAsForm(array $headers): bool
    {
        return isset($headers['Content-Type']) && $headers['Content-Type'] === 'application/x-www-form-urlencoded';
    }

}

