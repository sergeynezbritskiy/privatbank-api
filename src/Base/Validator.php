<?php

declare(strict_types=1);

namespace SergeyNezbritskiy\PrivatBank\Base;

use InvalidArgumentException;

/**
 * Class Validator
 * @package SergeyNezbritskiy\PrivatBank\Base
 */
class Validator
{

    public const TYPE_REQUIRED = 'required';
    public const TYPE_DEFAULT = 'default';

    /**
     * @param array $params
     * @param array $rules
     * @return array
     */
    public function validate(array $params, array $rules): array
    {
        foreach ($rules as $ruleData) {
            $fields = array_shift($ruleData);
            $rule = array_shift($ruleData);
            $fields = !is_array($fields) ? [$fields] : $fields;
            $this->validateParams($params, $rule, $fields, $ruleData);
        }
        return $params;
    }

    /**
     * @param array $params
     * @param string|\Closure $rule
     * @param array $fields
     * @param array $ruleData
     * @return void
     */
    private function validateParams(array &$params, $rule, array $fields, array $ruleData)
    {
        switch ($rule) {
            case self::TYPE_REQUIRED:
                foreach ($fields as $field) {
                    if (!array_key_exists($field, $params)) {
                        throw new InvalidArgumentException("Argument $field required");
                    }
                }
                break;
            case self::TYPE_DEFAULT:
                foreach ($fields as $field) {
                    if (empty($params[$field])) {
                        $params[$field] = $ruleData['value'];
                    }
                }
                break;
            case $rule instanceof \Closure:
                foreach ($fields as $field) {
                    $rule($params, $field);
                }
                break;
            default:
                throw new InvalidArgumentException("Unknown validator $rule");
        }
    }
}
