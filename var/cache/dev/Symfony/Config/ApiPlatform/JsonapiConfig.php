<?php

namespace Symfony\Config\ApiPlatform;

use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This class is automatically generated to help in creating a config.
 */
class JsonapiConfig 
{
    private $useIriAsId;
    private $allowClientGeneratedId;
    private $_usedProperties = [];

    /**
     * Set to false to use entity identifiers instead of IRIs as the "id" field in JSON:API responses.
     * @default true
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function useIriAsId($value): static
    {
        $this->_usedProperties['useIriAsId'] = true;
        $this->useIriAsId = $value;

        return $this;
    }

    /**
     * Allow client-generated IDs on JSON:API POST per https://jsonapi.org/format/#crud-creating-client-ids. Off by default to prevent id spoofing on public endpoints.
     * @default false
     * @param ParamConfigurator|bool $value
     * @return $this
     */
    public function allowClientGeneratedId($value): static
    {
        $this->_usedProperties['allowClientGeneratedId'] = true;
        $this->allowClientGeneratedId = $value;

        return $this;
    }

    public function __construct(array $config = [])
    {
        if (array_key_exists('use_iri_as_id', $config)) {
            $this->_usedProperties['useIriAsId'] = true;
            $this->useIriAsId = $config['use_iri_as_id'];
            unset($config['use_iri_as_id']);
        }

        if (array_key_exists('allow_client_generated_id', $config)) {
            $this->_usedProperties['allowClientGeneratedId'] = true;
            $this->allowClientGeneratedId = $config['allow_client_generated_id'];
            unset($config['allow_client_generated_id']);
        }

        if ($config) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($config)));
        }
    }

    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['useIriAsId'])) {
            $output['use_iri_as_id'] = $this->useIriAsId;
        }
        if (isset($this->_usedProperties['allowClientGeneratedId'])) {
            $output['allow_client_generated_id'] = $this->allowClientGeneratedId;
        }

        return $output;
    }

}
