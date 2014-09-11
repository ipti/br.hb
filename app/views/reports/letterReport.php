<?php
/* @var $this ReportsController */
header ('Content-type: text/html; charset=UTF-8'); 
$this->breadcrumbs = array(
    'Reports' => array('/reports'),
    'LetterReport',
);
?>
<style>
    p{
        text-indent: 50px;
    }
    #report img{
        width: 100%;
    }
    #report-logo{
        margin: auto auto 10px;
        width: 200px;
    }
    #report-content{
        margin: auto;
        border: 1px solid #000000;
        padding: 10px 5px 0;
        width: 700px;
    }
    #report-body{
        width: 100%;
        text-align: justify;
    }
    #report-footer{
        width: 100%;
        text-align: center;
    }
</style>
<div id="report">
    <div id="report-logo">
        <img src="../../../images/sntaluzia.png">
    </div>
    <div id="report-content">
        <div id="report-body">Prezados Pais,<br/><br/>
            <p>Como é do conhecimento de vocês, realizamos, a partir de uma gotinha de sangue tirada do dedo do seu filho(a)____________________________________, um exame que diagnostica a
                anemia.</p>
            <p>Ficamos preocupados, pois o resultado mostrou que a sua criança encontra-se com anemia. Vocês deverão levar seu filho à consulta médica, para que ele receba o tratamento:</p>
            <b>Dia da Consulta:</b>____/____/____<br/>
            <b>Hora da Consulta:</b> ____:____<br/>
            <b>Local da Consula:</b> ____________________________________<br/>
            <p>Gostaríamos de pedir a vocês para já prestarem atenção na alimentação da sua criança, principalmente nestes pontos:<br/><br/>
                <b>1 – Devemos oferecer às crianças, sempre que possível, carnes (de boi, frango ou peixe), feijão e folhas escuras, como couve e brócolis;<br/><br/>
                    2 – Devemos oferecer às crianças, logo após as refeições, sucos de frutas, principalmente as cítricas, como laranja e limão;<br/><br/>
                    3 – Não devemos deixar as crianças tomarem refrigerantes, chá ou café junto das refeições;<br/><br/>
                    4 – Lembrem-se também que leite faz muito bem, mas não junto das refeições. É melhor deixar passar duas horas após a refeição para dar leite às crianças.<br/></b><p/>
            Com estas medidas podemos ajudar as nossas crianças a ficarem sempre saudáveis e alegres.<br/><br/>
        </div>
        <div id="report-footer">Muito obrigado pela atenção.</div>
    </div>
</div>