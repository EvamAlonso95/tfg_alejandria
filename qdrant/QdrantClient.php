<?php
class QdrantClient
{
    private $host = 'localhost:6333';

    public function createCollection($collectionName, $vectorSize)
    {
        if ($this->collectionExists($collectionName)) {
            echo "La colección '$collectionName' ya existe. Saltando creación.";
            return;
        }

        $data = [
            "vectors" => [
                "size" => $vectorSize,
                "distance" => "Cosine",
                "on_disk" => true
            ]
        ];

        $this->request("/collections/$collectionName", "PUT", $data);
        echo "Colección '$collectionName' creada exitosamente con configuración optimizada.";
    }

    private function collectionExists($collectionName)
    {
        $response = $this->request("/collections", "GET");

        if (isset($response['result']) && is_array($response['result'])) {
            $existingCollections = array_column($response['result']['collections'], 'name');
            return in_array($collectionName, $existingCollections);
        }

        return false;
    }
    public function deleteCollection($collectionName)
    {
        $response = $this->request("/collections/$collectionName", "DELETE");
        return $response;
    }

    public function uploadVectors($collection, $vectors)
    {
        // Validar que haya vectores
        if (empty($vectors)) {
            throw new Exception("No hay vectores para cargar");
        }

        // Construir el payload para Qdrant
        $data = ['points' => []];

        foreach ($vectors as $index => $vectorData) {
            $point = [
                'id' => $vectorData['id'],
                'vector' => $vectorData['vector'],
                'payload' => $vectorData['payload']
            ];

            $data['points'][] = $point;
        }

        return $this->request("/collections/$collection/points", 'PUT', $data);
    }

    public function search($collection, $vector, $limit = 10, $filter = null)
    {
        $data = [
            'vector' => $vector,
            'limit' => $limit
        ];
        if ($filter) {
            $data["filter"] = $filter;
        }

        return $this->request("/collections/$collection/points/search", 'POST', $data);
    }


    public function getPoints($collection, $limit = 10)
    {
        $data = [
            "with_payload" => true,
            "with_vector" => true,
            "limit" => $limit
        ];

        return $this->request("/collections/$collection/points/search", "POST", $data);
    }

    public function request($endpoint, $method, $data = null)
    {
        $url = "http://$this->host$endpoint";
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER    => ['Content-Type: application/json'],
            CURLOPT_TIMEOUT       => 10, // Tiempo máximo de espera
        ]);

        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new Exception("Error en cURL: $error");
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 400) {
            $body = json_decode($response, true) ?? $response;
            var_dump($body);
            throw new Exception("Error HTTP $httpCode en $endpoint: " . print_r($body, true));
        }

        return json_decode($response, true);
    }

    public function getVectorId($collection, $id)
    {
        $response = $this->request("/collections/$collection/points/$id", "GET");
        return $response['result']['vector'] ?? null;
    }
}
