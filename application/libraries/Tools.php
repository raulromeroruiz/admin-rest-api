<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Tools {

    public function objeto($data)
    {
      return (object)$data;
    }

    public function urlfriendly($string)
    {
        $no = array("Á","É","Í","Ó","Ú","Ü","Ñ","á","é","í","ó","ú","ü","ñ");
        $si = array("A","E","I","O","U","U","N","a","e","i","o","u","u","n");
        $string = str_replace($no, $si, $string);
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $string));
    }

    public function cleanfilename($string)
    {
        $no = array("Á","É","Í","Ó","Ú","Ü","Ñ","á","é","í","ó","ú","ü","ñ");
        $si = array("A","E","I","O","U","U","N","a","e","i","o","u","u","n");
        $string = str_replace($no, $si, $string);
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return strtolower(preg_replace('/[^A-Za-z0-9._\-]/', '', $string));
    }

    public function datesql($date)
    {
        $f = explode("/", $date);
        return $f[2]."-".$f[1]."-".$f[0];
    }

    public function reload()
    {
        return "<script>top.location.reload();</script>";
    }

    public function alert($msg="Algo sucedio")
    {
        return "<script>top.alert('".strip_tags($msg)."');</script>";
    }

    public function url_file_upload($file, $path)
    {
        return $path.$file;
    }

    public function runfx($function)
    {
        return "<script>top.".$function."();</script>";
    }

    public function wordlimit($string, $length = 50, $ellipsis = "...")
    {
        $words = explode(' ', $string);
        if (count($words) > $length)
        {
            return implode(' ', array_slice($words, 0, $length)) . $ellipsis;
        }
        else
        {
            return $string;
        }
    }

    public function generate_password()
    {
        $password = "";
        for($x=1; $x<6; $x++) {
            $password .= chr(rand(48,57));
        }
        return $password;
    }

    public function paginacion($per_page, $base, $total_rows)
    {
        $opciones = array(
            'per_page' => $per_page,
            'base_url' => $base,
            'total_rows' => $total_rows,
            'uri_segment' => 3,
            'full_tag_open' =>'<ul class="pagination pull-right">',
            'full_tag_close' =>'</ul>',
            'num_tag_open' =>'<li>',
            'num_tag_close' =>'</li>',
            'first_link' =>FALSE,
            'prev_link' =>'<span class="glyphicon glyphicon-chevron-left"></span>',
            'prev_tag_open' =>'<li>',
            'prev_tag_close' =>'</li>',
            'last_link' =>FALSE,
            'next_link' =>'<span class="glyphicon glyphicon-chevron-right"></span>',
            'next_tag_open' =>'<li>',
            'next_tag_close' =>'</li>',
            'cur_tag_open' =>'<li class="active"><a href"javascript:;">',
            'cur_tag_close' =>'</a></li>',
            'num_links' => 3,
            'use_page_numbers' => TRUE
        );
        return $opciones;
    }

    public function pagination($pagina, $per_page, $base, $total_rows, $params)
    {
        $pagination = '<ul class="pagination">';

        $pagina = (isset($params['pagina'])) ? $params['pagina']:1;

        $total_paginas = ceil($total_rows / $per_page);

        $query = array();
        if ($params) {
            foreach ($params as $key => $value) {
                $value = ($key!="pagina") ? $value:"";
                $query[] = $key.'='.$value;
            }
            //$query_string = "?categoria=".$params['categoria']."&pagina=";
            $query_string = "?".implode("&", $query);
        }
        else {
            $query_string = "?pagina=";
        }

        if ($total_paginas > 1){ 
            for ($i=1;$i<=$total_paginas;$i++){ 
                if ($pagina == $i) {
                    //si muestro el índice de la página actual, no coloco enlace 
                    $pagination .= "<li class='active'><a href='javascript:;'>". $pagina . "</a></li>"; 
                }
                else  {
                    //si el índice no corresponde con la página mostrada actualmente, coloco el enlace para ir a esa página 
                    $pagination .= "<li><a href='".$base. $query_string . $i . "'>" . $i . "</a></li>"; 
                }
            } 
        }

        $pagination .= '</ul>';

        return $pagination;
    }

    public function searchfield($field, $result) {

        if (!empty($result)) {
            switch ($field) {
                case 'correo':
                    //echo "<script>top.alert('El correo ya está registrado')</script>";
                    echo json_encode( array('result'=>"error", 'message'=>"El correo ya está registrado") );
                    break;
                case 'username':
                    //echo "<script>top.alert('El nombre de usuario ya está registrado')</script>";
                    echo json_encode( array('result'=>"error", 'message'=>"El nombre de usuario ya está registrado") );
                    break;
            }

            exit;
        }
        //return TRUE;
    }

    #Functins Beta
    public function dateformat($date, $format)
    {
        $meses = array('','Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        list($dia, $mes, $ano) = explode(" ", $format);
        $f = explode("-", $date);

        switch ($mes) {
            case 'm':
                $mm = $f[1];
                break;
            case 'M':
                $mm = substr($meses[intval($f[1])], 0, 3);
                break;
            case 'MM':
                $mm = $meses[$f[1]];
                break;
        }

        return $f[2]." ".$mm." ".$f[0];
    }

    public function onlyChars($string)
    {
        $no = array("Á","É","Í","Ó","Ú","Ü","Ñ","á","é","í","ó","ú","ü","ñ");
        $si = array("A","E","I","O","U","U","N","a","e","i","o","u","u","n");
        $string = str_replace($no, $si, $string);
        return preg_replace('/[^A-Za-z0-9._\-]/', '', $string);
    }

    public function sizes($section="", $tmp="")
    {
        @$size = getimagesize($tmp);

        switch ($section) {
            case 'noticias':
                $w = $size[0];
                $h = $size[1];
                if ($size[0]>$size[1]) {
                    $h = 400;
                    $w = ($size[0]*$h)/$size[1];
                }
                elseif ($size[1]>$size[0]) {
                    $w = 400;
                    $h = ($size[1]*$w)/$size[0];
                }
                return array(
                    array('full', 960, ($size[1]*960) / $size[0]),
                    array('medium', $w, $h),
                    array('small', 75, 75),
                );
                break;

            case 'clientes':
                if ($size[0]!=$size[1]){
                    if ($size[0]>$size[1]){
                    #image horizontal
                        $ri = $size[1] / $size[0];
                        $rii = ceil(( $size[1] / $size[0] ) * 10);

                        $marginw = ( 300 * $ri ) + $rii;
                        $w = 540 - ($marginw * 2);
                        $h = $w * $ri;
                    }
                    elseif($size[1]>$size[0]) {
                    #image vertical
                        $ri = $size[0] / $size[1];
                        $rii = ceil(( $size[0] / $size[1] ));

                        $marginh =  ( 300 * $ri );
                        $w = 540 - $marginh;
                        $h = $w * $ri;
                        $size_tmp = $size[0];
                        $size[0] = $size[1];
                        $size[1] = $size_tmp;
                    }
                }
                else {
                    $w = $h = 90;
                }

                return array(
                    array('full', 419, ($size[1]*419) / $size[0]),
                    array('medium', $w, ($size[1]*$w) / $size[0]),
                    array('small', 150, 75),
                );

                break;

            case 'obras':
                $w = $size[0];
                $h = $size[1];
                if ($size[0]>$size[1]) {
                    $h = 400;
                    $w = ($size[0]*$h)/$size[1];
                }
                elseif ($size[1]>$size[0]) {
                    $w = 400;
                    $h = ($size[1]*$w)/$size[0];
                }
                return array(
                    array('full', 419, 419),
                    array('medium', $w, $h),
                    array('small', 75, 75),
                );
                break;

            case 'foto':
                return array(
                    'full'  => array(971, 717),
                    'small' => array(160, 160),
                );
                break;

            case 'lista':
                return array(
                    'full'  => array(971, 717),
                    'small' => array(120, 120),
                );
                break;

            case 'banner':
                return array(
                    'full'  => array(790, 470),
                    'small' => array(120, 120),
                );
                break;

            case 'planos':
                return array(
                    'full'  => array(480, 470),
                    'small' => array(120, 120),
                );
                break;

            case 'proyectos':
                $w = $size[0];
                $h = $size[1];
                if ($size[0]>$size[1]) {
                    $h = 400;
                    $w = ($size[0]*$h)/$size[1];
                }
                elseif ($size[1]>$size[0]) {
                    $w = 400;
                    $h = ($size[1]*$w)/$size[0];
                }
                return array(
                    array('full', 419, 419),
                    array('medium', $w, $h),
                    array('small', 75, 75),
                );
                break;
            
            case 'banners':
                return array(
                    array('full', 1680, 400),
                    array('medium', 300, 300),
                    array('small', 75, 75),
                );
                break;
            
            case 'banner_mobile':
                return array(
                    array('full', 768, 576),
                    array('medium', 300, 300),
                    array('small', 120, 120),
                );
                break;

            case 'testimonios':
                return array(
                    array('full', 200, 200),
                    array('small', 40, ($size[1]*40) / $size[0]),
                );
                break;

            default:
                # code...
                break;
        }
    }

    public function error_upload($errors=array(), $cfg=array())
    {
        $error = FALSE; $msgerr = "";
        foreach ($errors as $key => $msg) {
            switch ($key) {
                case 'upload_invalid_filetype':
                    $error = TRUE;
                    $msgerr  = $msg;
                    $msgerr  = sprintf($msg, $cfg['allowed_types']);
                    break;

                case 'upload_invalid_dimensions':
                    $error = TRUE;
                    $str = ($cfg['exactly']) ? "exactamente":"menores o";
                    $msgerr  = sprintf($msg, $str, $cfg['max_width'], $cfg['max_height']);
                    break;

                case 'upload_invalid_filesize':
                    $error = TRUE;
                    $msgerr  = $msg;
                    break;

                case 'upload_file_exceeds_limit':
                    $error = TRUE;
                    $msgerr  = 'Error en el Servidor.\nPongase en contacto con algún representante de Cevichelabs';
                    break;

                default:
                    $error = FALSE;
                    $msgerr = "";
                    break;
            }
        }
        return array('result' =>$error, 'msg'=>$msgerr);
    }

    public function redirect($url="/") {
        printf("<script>location.href='".$url."'</script>");
    }
}
