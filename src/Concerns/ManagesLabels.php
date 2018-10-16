<?php

declare(strict_types=1);

namespace P7v\Todoist\Concerns;

use GuzzleHttp\Client;
use P7v\Todoist\Entities\Label;

trait ManagesLabels
{
    /** @var Client */
    private $httpClient;

    /**
     * @return Label[]
     */
    public function getAllLabels(): array
    {
        $response = $this->httpClient->get('labels')
            ->getBody()
            ->getContents();

        $records = json_decode($response, true);

        return array_map(function (array $record) {
            return new Label($record['id'], $record['name'], $record['order']);
        }, $records);
    }

    public function createNewLabel(string $name, int $order = null): Label
    {
        $json = [
            'name' => $name,
        ];

        if (!is_null($order)) {
            $json['order'] = $order;
        }

        $response = $this->httpClient->post('labels', [
            'json' => $json,
        ])->getBody()->getContents();

        $record = json_decode($response, true);

        return new Label($record['id'], $record['name'], $record['order']);
    }

    public function getLabel(int $id): Label
    {
        $url = 'labels/' . $id;

        $response = $this->httpClient->get($url)
            ->getBody()
            ->getContents();

        $record = json_decode($response, true);

        return new Label($record['id'], $record['name'], $record['order']);
    }

    public function updateLabel(Label $label): bool
    {
        $url = 'label/' . $label->getId();

        $this->httpClient->post($url, [
            'json' => [
                'name' => $label->getName(),
                'label' => $label->getOrder(),
            ],
        ]);

        return true;
    }

    public function deleteLabel(Label $label): bool
    {
        $url = 'labels/' . $label->getId();

        $this->httpClient->delete($url);

        return true;
    }
}
