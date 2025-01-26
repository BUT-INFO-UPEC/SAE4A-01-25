<?php

namespace Src\Model\DataObject;

class Requette_API
{
    private const BASE_URL = "https://public.opendatasoft.com/api/explore/v2.1/catalog/datasets/donnees-synop-essentielles-omm/records";
    private array $parameters = [];

    /**
     * Set the select parameter.
     * @param array|string|null $fields Fields to select
     * @return $this
     */
    public function select(array|string|null $fields): self
    {
        if ($fields !== null) {
            $this->parameters['select'] = is_array($fields) ? implode(',', $fields) : $fields;
        }
        return $this;
    }

    /**
     * Set the where parameter.
     * @param array|string|null $conditions Filtering conditions
     * @return $this
     */
    public function where(array|string|null $conditions): self
    {
        if ($conditions !== null) {
            $this->parameters['where'] = is_array($conditions) ? implode(' AND ', $conditions) : $conditions;
        }
        return $this;
    }

    /**
     * Set the group_by parameter.
     * @param array|string|null $fields Fields to group by
     * @return $this
     */
    public function groupBy(array|string|null $fields): self
    {
        if ($fields !== null) {
            $this->parameters['group_by'] = is_array($fields) ? implode(',', $fields) : $fields;
        }
        return $this;
    }

    /**
     * Set the order_by parameter.
     * @param array|string|null $fields Fields to order by
     * @return $this
     */
    public function orderBy(array|string|null $fields): self
    {
        if ($fields !== null) {
            $this->parameters['order_by'] = is_array($fields) ? implode(',', $fields) : $fields;
        }
        return $this;
    }

    /**
     * Set the limit parameter.
     * @param int|null $limit Number of results
     * @return $this
     */
    public function limit(?int $limit): self
    {
        if ($limit !== null) {
            $this->parameters['limit'] = $limit;
        }
        return $this;
    }

    /**
     * Set the offset parameter.
     * @param int|null $offset Index of the first result
     * @return $this
     */
    public function offset(?int $offset): self
    {
        if ($offset !== null) {
            $this->parameters['offset'] = $offset;
        }
        return $this;
    }

    /**
     * Set the refine parameter.
     * @param array|null $refinements Key-value pairs for refinements
     * @return $this
     */
    public function refine(?array $refinements): self
    {
        if ($refinements !== null) {
            $formatted = [];
            foreach ($refinements as $key => $value) {
                $formatted[] = "$key:$value";
            }
            $this->parameters['refine'] = implode(',', $formatted);
        }
        return $this;
    }

    /**
     * Set the exclude parameter.
     * @param array|null $exclusions Key-value pairs for exclusions
     * @return $this
     */
    public function exclude(?array $exclusions): self
    {
        if ($exclusions !== null) {
            $formatted = [];
            foreach ($exclusions as $key => $value) {
                $formatted[] = "$key:$value";
            }
            $this->parameters['exclude'] = implode(',', $formatted);
        }
        return $this;
    }

    /**
     * Set the lang parameter.
     * @param string|null $lang Language code
     * @return $this
     */
    public function lang(?string $lang): self
    {
        if ($lang !== null) {
            $this->parameters['lang'] = $lang;
        }
        return $this;
    }

    /**
     * Set the timezone parameter.
     * @param string|null $timezone Timezone
     * @return $this
     */
    public function timezone(?string $timezone): self
    {
        if ($timezone !== null) {
            $this->parameters['timezone'] = $timezone;
        }
        return $this;
    }

    /**
     * Build the final URL with the parameters.
     * @return string The constructed URL
     */
    public function buildUrl(): string
    {
        $queryString = http_build_query($this->parameters, '', '&', PHP_QUERY_RFC3986);
        return self::BASE_URL . ($queryString ? '?' . $queryString : '');
    }
}
