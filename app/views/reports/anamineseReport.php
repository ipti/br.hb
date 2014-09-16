<?php
/* @var $this ReportsController */

$this->breadcrumbs = array(
    'Reports' => array('/reports'),
    'TermReport',
);
?>
<style>
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
    #head{
        font-weight: bold;
        text-align: center;
    }
    //table, tr, th, td {border: 1px solid black;}
    table {width:100%;}
    th{text-align: left; width: 33%;}

    div#par{
        padding: 5px;
        background-color: #EEE;
        border: 1px solid lightgrey;
    }
    div#impar{
        padding: 5px;
        background-color: #E5ECF9;
        border: 1px solid lightblue;
    }
</style>
<div id="report">
    <div id="report-logo">
        <img src="../../../images/sntaluzia.png">
    </div>
    <div id="report-content">
        <div id="head">QUESTIONÁRIO DE ANAMNESE<br>
        Tecnologia Social Hb</div>
        <br>
        <div id="infos">
            <table>
                <tr><th>Nome:</th></tr>
                <tr><th>Nascimento:</th><th>Idade:</th></tr>
                <tr><th>Sexo:</th><th>Peso:</th><th>Altura:</th></tr>
                <tr><th>IMC:</th><th>Hb1:</th></tr>
            </table>
        </div>
        <hr>
        <div id='impar'>
        A criança já foi internada alguma vez?
        <pre>(    ) SIM             (    ) NÃO</pre>

        Se SIM, qual foi o motivo?<br>
        <br>
        <hr>
        </div>
        <div id='par'>
        Já teve Pneumonia?
        <pre>(    ) SIM             (    ) NÃO</pre>

        Quantas vezes?
        <pre>(    ) 1               (    ) 2              (    ) 3              (    ) 4 ou mais</pre>
        </div>
        <div id='impar'>
        Tem alergia a algum medicamento?
        <pre>(    ) SIM             (    ) NÃO</pre>
        Qual?<hr>
        </div>
        <div id='par'>
        Inchava os pés ou as mãos quando era um bebê?
        <pre>(    ) SIM             (    ) NÃO</pre>
        </div>
        <div id='impar'>
        Já fez exame de sangue?
        <pre>(    ) SIM             (    ) NÃO</pre>
        </div>
        <div id='par'>
        Já teve anemia anteriormente?
        <pre>(    ) SIM             (    ) NÃO</pre>
        Quantas vezes?
        <pre>(    ) 1               (    ) 2            (    ) 3                (    ) 4 ou mais</pre>
        Como foi tratada?
        <pre>(    ) Sulfato Ferroso (    ) Dieta        (    ) Outros: _________________________</pre>
        Melhorou com o tratamento:
        <pre>(    ) SIM             (    ) NÃO          (    ) Não completou o tratamento</pre>
        </div>
        <div id='impar'>
        Existem outras pessoas na família que têm ou já tiveram anemia?
        <pre>(    ) SIM             (    ) NÃO</pre>

        Se SIM, quem?	
        <pre>(    ) Irmão(a)        (    ) Pai ou Mãe   (    ) Outros: _________________________</pre>
        </div>
        <br>
        <br>
        OBS:
        <hr>
        <br>
        <hr>
    </div>
</div>