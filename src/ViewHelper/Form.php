<?php

namespace LevForm\ViewHelper;

use LevForm\Form\BaseForm;

class Form extends BaseForm{

    public function __invoke($elem) {
        $html = '<div class="row">';
        $attr = function($array) {
            $at = '';
            foreach ($array as $name => $val) {
                $at .= ' ' . $name . '="' . $val . '" ';
            }
            return $at;
        };

        $html.= '<form ' . $attr($elem['_form']) . '>';
        unset($elem['_form']);

        foreach ($elem as $name => $e) {
            $col = isset($e['col']) ? $e['col'] : 12;
            $label = isset($e['label']) ? $e['label'] : null;
            $desc = isset($e['desc']) ? $e['desc'] : null;
            $id = isset($e['id']) ? $e['id'] : $name;
            $type = isset($e['type']) ? $e['type'] : 'text';
            $val = isset($e['val']) ? $e['val'] : null;
            $at = isset($e['attr']) ? $e['attr'] : array();
            $option = isset($e['option']) ? $e['option'] : array();
            $db = isset($e['db']) ? $e['db'] : false;

            $html.='<div class="col-md-' . $col . '" >';
            $html.='<div class="form-group" >';

            if ($type == 'text') {
                $html.='<label>' . $label . '</label>';
                $html.='<input ' . $attr($at) . ' type="text" class="form-control" name="' . $name . '" id="' . $id . '" placeholder="' . $desc . '" value="' . $val . '">';
            }

            if ($type == 'password') {
                $html.='<label>' . $label . '</label>';
                $html.='<input ' . $attr($at) . ' type="password" class="form-control" name="' . $name . '" id="' . $id . '" placeholder="' . $desc . '" value="' . $val . '">';
            }
            if ($type == 'textarea') {
                $html.='<label>' . $label . '</label>';
                $html.='<textarea ' . $attr($at) . ' class="form-control" name="' . $name . '" id="' . $id . '" placeholder="' . $desc . '">' . $val . '</textarea>';
            }
            if ($type == 'select') {
                $html.='<label>' . $label . '</label>';
                $html.='<select ' . $attr($at) . ' class="form-control" name="' . $name . '" id="' . $id . '">';
                //Obtem dados do banco
                $html.='<option value=""></option>';

                if ($db) {
                    $model = new $db[0]();

                    $option = call_user_func([$model, $db[1]]);

                    foreach ($option as $r) {
                        $selected = null;
                        if ($val == $r['value']) {
                            $selected = 'selected';
                        }
                        $html.='<option value="' . $r['value'] . '" ' . $selected . '>' . $r['text'] . '</option>';
                    }
                } else {
                    foreach ($option as $value => $name) {
                        $selected = null;
                        if ($val == $value) {
                            $selected = 'selected';
                        }
                        $html.='<option value="' . $value . '" ' . $selected . '>' . $name . '</option>';
                    }
                }
                $html.= '</select>';
            }
            if ($type == 'submit') {
                $html.='<button ' . $attr($at) . ' class="btn btn-primary" name="' . $name . '" id="' . $id . '">' . $desc . '</button>';
            }

            $html.='</div></div>';
        }
        $html.='</form>';
        $html.='</div>';
        return $html;
    }
}
