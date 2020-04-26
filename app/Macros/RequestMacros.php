<?php
return [

    /**
     * wantsXml function.
     *
     * @access public
     * @return void
     */
    'wantsXml' => function () {
        return Str::contains($this->header('Accept'), 'xml');
    },

    /**
     * isXml function.
     *
     * @access public
     * @param mixed $file
     * @param mixed $filename
     * @param int $status (default: 200)
     * @param mixed $headers (default: [])
     * @return void
     */
    'isXml' => function ($file, $filename, $status = 200, $headers = []) {
        return strtolower($this->getContentType()) === 'xml';
    },

    /**
     * xml function.
     *
     * @access public
     * @param mixed $file
     * @param mixed $filename
     * @param int $status (default: 200)
     * @param mixed $headers (default: [])
     * @return void
     */
    'xml' => function ($file, $filename, $status = 200, $headers = []) {
        if (!$this->isXml()) {
            return [];
        }
        try {
            return \App\Services\XmlToArray::convert($this->getContent()) ?: [];
        } catch (Exception $exception) {
            throw \App\Exceptions\CouldNotParseXml::payload($this->getContent());
        }
    }
];
