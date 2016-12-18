<?php

namespace LevForm\Form;

abstract class BaseForm {

    protected $elements;

    function setValues($dados) {
        if (is_array($dados)) {
            foreach ($dados as $name => $val) {
                if (array_key_exists($name, $this->elements)) {
                    $this->elements[$name]['val'] = $val;
                }
            }
        }
        return $this->elements;
    }

    protected function add($elem, $dados = null) {
        $this->elements = $elem;
        return $this->setValues($dados);
    }

}
