<?php

class Form {

    const FRONT_CLASSES = [
        'label',
        'type',
        'classList'
    ];
    private $separator;
    private $fields = [];
    private $formContent;

    public function __construct(string $separator = "p") {

        $this->separator = $separator;

    }

    private function getSeparator(string $position, string $separator = null) {

        $separator = isset($separator) ? $separator : $this->separator;

        $validPositions = ['start', 'end'];

        if ( ! in_array($position, $validPositions) ) {
            throw new Exception('La position est invalide.');
        }

        $string = '';

        switch($position) {
            case 'start':
                $string = "<" . $separator . ">";
                break;

            case 'end':
                $string = "</" . $separator . ">";
                break;

            default:
                throw new Exception('La position est invalide.');
        }

        return $string;
    }

    private function setField(string $field) {
        $fieldId = uniqId();
        $this->fields[$fieldId] = [];
        $this->fields[$fieldId]['field'] = $field;

        return $fieldId;
    }

    private function initField(string $fieldId, string $name, array $params = null) {

        $this->fields[$fieldId]['name'] = $name;

        if (isset($params)) {
            foreach ($params as $key => $value) {
                $this->fields[$fieldId][$key] = $value;
            }
        }

        return $this;
    }

    /**
     * @param string name Input $name
     * @param string type Input $type (optional) default = "text"
     */
    public function input(string $name, array $params = null, $separator = null) {

        $fieldId = $this->setField('input');
        $this->initField($fieldId, $name, $params);
    }

    public function select(string $name, array $params = null, $separator = null) {

        $fieldId = $this->setField('select');
        $this->initField($fieldId, $name, $params);
    }

    public function generate() {
        $reflectionClass = new ReflectionClass(get_class($this));

        foreach ($this->fields as $fieldId => $field) {

                if ($reflectionClass->hasMethod( 'generate' . $field['field']) ) {

                    $methodName = 'generate' . $field['field'];
                    $this->$methodName($fieldId);

                } else {
                    throw new Exception('La classe de générateur demandée n\'existe pas.');
                }
        }
    }


    private function generateInput(string $fieldId) {

        $validAttributes = ['accept', 'align', 'alt', 'autocomplete', 'autofocus', 'checked', 'dirname', 'disabled', 'form', 'formaction', 'formenctype', 'formmethod', 'formnovalidate', 'formtarget', 'height', 'list', 'max', 'maxlength', 'min', 'multiple', 'name', 'pattern', 'placeholder', 'readonly', 'required', 'size', 'src', 'step', 'type', 'value', 'width',];

        $inputAttr = $this->fields[$fieldId];

        $attributes = '';
        $label = '';
        foreach($inputAttr as $attr => $value) {
            if ( in_array($attr, $validAttributes) ) {
                $attributes .= $attr . '="' . $value . '" ';
            }

            if ($attr === 'label' ) {
                $label = '<label for = "' . $fieldId . '">'. $value .'</label>';
            }
        }

        $attributes = "id=" . $fieldId . " " . $attributes;

        var_dump($inputAttr);
        var_dump($attributes);
        var_dump($label);


        $finalString = $label . '<input '.$attributes.'>';

        echo $finalString;

    }

    private function generateSelect(string $fieldId) {

    }
}