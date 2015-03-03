<?php namespace Tcsehv\JwtApiClient\Resources;

class Helper
{

    /**
     * Validate provided data against the list of required fields
     * This function throws an error if there are invalid fields
     *
     * @param array $data
     * @param array $requiredFields
     * @param string $key
     * @throws \RuntimeException
     */
    public static function validateFields(array $data, array $requiredFields, $key)
    {
        $invalidFields = array();

        // Loop through the list of required fields
        foreach ($requiredFields as $requiredField) {
            if (!array_key_exists($requiredField, $data) || empty($data[$requiredField])) {
                $invalidFields[$requiredField] = $requiredField;
            }
        }

        if (!empty($invalidFields)) {
            throw new \RuntimeException('Please provide the following field(s) in key \'' . $key . '\': ' . implode(', ', array_values($invalidFields)));
        }
    }

}