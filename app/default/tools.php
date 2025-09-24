<?php

    function tool_pagination($page, $total, $url){

        if($total > 1){ 

            $number = '';       
            if($page > 1){
                $number .= '<li class="page-item prev"><a href="'.$url.($page - 1).'" class="page-link"><i class="fa fa-angle-left"></i></a></li>';
            }

            $startpage = (($page - 2) <= 0 ? 1 : $page - 2);

            if($page >= $total){
                $counter = $total;
                $startpage = ($page > 5 ? $page - 4 : $total - ($page - 1));
            }else{
                if($total > 5){
                    if($page >= $total - 2){
                        $startpage = $total - 4;
                    }elseif($page >= $total - 3){
                        $startpage = $total - 5;
                    }
                }else{
                    if($page <= 5){
                        $startpage = 1;
                    }
                }

                if($page <= 3){
                    $counter = 5;
                }else{
                    $counter = (($page + 3) - 1);
                }
            }

            for($i = $startpage; $i <= $counter; $i++){
                if($total >= $i){
                    if($i==$page){
                        $number  .= '<li class="page-item active"><a class="page-link">'.$i.'</a></li>';
                    }else{
                        $number  .= '<li class="page-item"><a href="'.$url.$i.'" class="page-link">'.$i.'</a></li>';
                    }
                }
            }
            
            if($page < $total){
                $number .= '<li class="page-item next"><a href="'.$url.($page + 1).'" class="page-link"><i class="fa fa-angle-right"></i></a></li>';
            }

            $pages = '<div class="d-flex align-items-center justify-content-center">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-basic mg-b-0">'.$number.'</ul>
                        </nav>
                        </div>
                     ';

            return $pages;

        }
    }
    
    function tool_dropdown($list, $column, $item, $name='', $parent_id=''){
        if(is_array($list)){
            $option = '<option label=""></option>
                       <option value="0">---</option>';
            foreach($list as $key => $value){
                if(htmlDecode($value[$column]) == $item){
                    $option .= '<option id="'.htmlDecode($value['id']).'" value="'.htmlDecode($value[$column]).'" data-parent="'.(!empty($parent_id) ? htmlDecode($value[$parent_id]) : '').'" selected>'.(empty($name) ? htmlDecode($value['name']) : htmlDecode($value[$name])).'</option>';
                }else{
                    $option .= '<option id="'.htmlDecode($value['id']).'" value="'.htmlDecode($value[$column]).'" data-parent="'.(!empty($parent_id) ? htmlDecode($value[$parent_id]) : '').'" >'.(empty($name) ? htmlDecode($value['name']) : htmlDecode($value[$name])).'</option>';
                }

            }
        }else{
            $option = '<option value="">No record found</option>';
        }

        return $option;     
    }

    function tool_dropdown_option($list, $id, $name='', $parent_id=''){
        if(is_array($list)){
            //<option value="0">---</option>
            $option = '<option label=""></option>';
            foreach($list as $key => $value){
                //$option .= $value['id'];
                if(htmlDecode($value['id']) == $id){
                    $option .= '<option value="'.htmlDecode($value['id']).'" data-parent="'.(!empty($parent_id) ? htmlDecode($value[$parent_id]) : '').'" selected>'.(empty($name) ? htmlDecode($value['name']) : htmlDecode($value[$name])).'</option>';
                }else{
                    $option .= '<option value="'.htmlDecode($value['id']).'" data-parent="'.(!empty($parent_id) ? htmlDecode($value[$parent_id]) : '').'" >'.(empty($name) ? htmlDecode($value['name']) : htmlDecode($value[$name])).'</option>';
                }

            }
        }else{
            $option = '<option value="">No record found</option>';
        }

        pre($option); exit;

        return $option;     
    }

    function tool_dropdown_money($list, $id, $name='', $amount=''){
        if(is_array($list)){
            //<option value="0">---</option>
            $option = '<option label=""></option>';
            foreach($list as $key => $value){
                //$option .= $value['id'];
                if(htmlDecode($value['id']) == $id){
                    $option .= '<option value="'.htmlDecode($value['id']).'" data-amount="'.(!empty($amount) ? htmlDecode($value[$amount]) : '').'" selected>'.formatMoney((empty($name) ? htmlDecode($value['name']) : htmlDecode($value[$name]))).'</option>';
                }else{
                    $option .= '<option value="'.htmlDecode($value['id']).'" data-amount="'.(!empty($amount) ? htmlDecode($value[$amount]) : '').'" >'.formatMoney((empty($name) ? htmlDecode($value['name']) : htmlDecode($value[$name]))).'</option>';
                }

            }
        }else{
            $option = '<option value="">No record found</option>';
        }

        return $option;     
    }

    function tool_dropdown_default($list, $value){
        $option = '<option value="0">---</option>';
        if(is_array($list)){
            foreach($list as $row){
                if($row == $value){
                    $option .= '<option value="'.$row.'" selected>'.$row.'</option>';
                }else{
                    $option .= '<option value="'.$row.'">'.$row.'</option>';
                }
            }   
        }else{
            $option .= '<option value="">No record found</option>';
        }

        return $option;     
    }

    function tool_dropdown_with_all($list, $id, $name='', $parent_id=''){
        if(is_array($list)){
            
            if ( htmlDecode($id) == 'all' ) {
                $option = '<option value="all" selected>All</option>';
            }else{
                $option = '<option value="all">All</option>';
            }

            foreach($list as $key => $value){
                //$option .= $value['id'];
                if(htmlDecode($value['id']) == $id){
                    $option .= '<option value="'.htmlDecode($value['id']).'" data-parent="'.(!empty($parent_id) ? htmlDecode($value[$parent_id]) : '').'" selected>'.(empty($name) ? htmlDecode($value['name']) : htmlDecode($value[$name])).'</option>';
                }else{
                    $option .= '<option value="'.htmlDecode($value['id']).'" data-parent="'.(!empty($parent_id) ? htmlDecode($value[$parent_id]) : '').'" >'.(empty($name) ? htmlDecode($value['name']) : htmlDecode($value[$name])).'</option>';
                }

            }

        }else{
            $option = '<option value="">No record found</option>';
        }

        return $option;     
    }
/*
    function tool_checkbox($type, $name, $list, $set='', $label='', $required=''){
        if(is_array($list)){
            $checkbox = '
                            <div class="form-group block">
                                '.(!empty($label) ? '<label>'.$label.'</label>' : '');

                                $ctr = 1;
                                foreach($list as $row => $value){
                                    if(in_array($row, explode('_', $set))){
                                    //if($row == $value){
                                        $selected = 'checked';
                                    }else{
                                        $selected = '';
                                    }

                                    if($required == 'Yes' && $ctr == 1){
                                        $required = 'required';
                                    }else{
                                        $required = '';
                                    }

            if($type == 'inline'){
            $checkbox .= '
                                <label class="checkbox-inline">
                                    <input name="'.$name.'[]" type="checkbox" value="'.$row.'" '.$selected.' '.$required.'> &nbsp; '.$value.'
                                </label>
                         ';
            }else{
            $checkbox .= '
                                <!--<div class="checkbox">-->
                                    <label class="ckbox">
                                        <input name="'.$name.'[]" type="checkbox" value="'.$row.'" data-content="'.$row.'_'.$value.'" '.$selected.' '.$required.'><span>'.$value.'</span>
                                    </label>
                                <!--</div>-->
                         ';
            }
                                    $ctr++;
                                }   
            $checkbox .= '
                            </div>
                         ';
        }else{
            $checkbox = 'No checkbox available';
        }

        return $checkbox;
    }
*/

    function tool_checkbox($value){
        if($value == 'on'){
            return 'checked';
        }
    }

    function tool_radio($type, $name, $list, $field='', $value='', $label='', $required=''){
        if(is_array($list)){
            $checkbox = '
                            <div class="form-group block">
                                '.(!empty($label) ? '<label>'.$label.'</label>' : '');

                                $ctr = 1;
                                foreach($list as $row){
                                    if(in_array((empty($field) ? $row : $row[$field]), explode('_', $value))){
                                    //if($row == $value){
                                        $selected = 'checked';
                                    }else{
                                        $selected = '';
                                    }

                                    if($ctr == 1){
                                        $required = $required;
                                    }else{
                                        $required = '';
                                    }

            if($type == 'inline'){
            $checkbox .= '
                                <label class="radio-inline">
                                    <input name="'.$name.'[]" type="radio" value="'.(empty($field) ? $row : $row[$field]).'" '.$selected.' '.$required.'>'.(empty($field) ? $row : $row[$field]).'
                                </label>
                         ';
            }else{
            $checkbox .= '
                                <div class="radio">
                                    <label>
                                        <input name="'.$name.'[]" type="radio" value="'.(empty($field) ? $row : $row[$field]).'" '.$selected.' '.$required.'>'.(empty($field) ? $row : $row[$field]).'
                                    </label>
                                </div>
                         ';
            }
                                    $ctr++;
                                }   
            $checkbox .= '
                            </div>
                         ';
        }else{
            $checkbox = 'No radio button available';
        }

        return $checkbox;
    }
?>