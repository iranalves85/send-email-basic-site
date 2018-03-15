<?php
/*
 * 27/07/2017
 * Template para E-mails
 */

//Definindo a região para data e horas
function setBrazilDate(){
    setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
}

//Define a quatidade de colunas e estilos css
function setTdColumns($data, $qtd, $style, $name = ''){
    $i = 0;
    $html = '';
    foreach($data as $key => $value ):
        
        $campo = ( empty($name))? str_replace('_', ' ', $key) : $name; //verifica se name foi setado, senão utiliza key de array como nome e troca underlines por espaço
        $campo = ucwords($campo);//Palavras em maisculo
        
        if( $i==0 ): 
            $html .= '<tr>';
        endif;        
        
        $html .= '<td style="font-family: Arial, no-serif;text-align:left;padding:10px;border:1px solid #ccc;vertical-align:top;' . $style . '"><b style="font-size:11px;text-transform:uppercase;">'. $campo . '</b><br /><span style="display:block;padding: 10px 0px 0px;min-height:30px;font-size:13px;">'. $value .'</span></td>';                
        
        if( $i > $qtd ): 
            $html .= '</tr>';            
        endif;   
        
        if( $i > $qtd ): $i = 0;  else: $i++; endif; //reseta contagem
        
    endforeach;
    
    return $html;
    
}

// Seguro Torcedor
function emailTemplate($data){
    
    $html = '<table border="0" cellpadding="10" align="center" width="100%" style="width:100%;border: 1px solid #ccc;margin: 10px auto 20px;">    
        <thead>
            <tr>
                <td colspan="3" style="background-color: #f1f1f1;text-align: center;padding:10px;font-family: Arial, no-serif;">
                    <b>Mensagem</b>
                </td>
            </tr>
        </thead>
        <tbody>';
    
    $html .= setTdColumns($data['msg'], 0, '');
    
    $html .= '</tbody>        
            </table>            
            ';
    
    return $html;
    
}