<?php
/* @var $this ReportsController */

$this->breadcrumbs = array(
    'Reports' => array('/reports'),
    'TermReport',
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
    #report-head{
        font-weight: bold;
        text-align: center;
    }
    #report-body{
        width: 100%;
        text-align: center;
    }
    #report-footer{
        width: 100%;
        text-align: center;
    }
    .span-bold{
        font-weight: bold;
    }

</style>
<div id="report">
    <div id="report-logo">
        <img src="../../../images/sntaluzia.png">
    </div>
    <div id="report-content">
        <div id="report-head">RECEITUÁRIO</div>
        <br>
        <br>
        <div id='report-body'>{student.name}
            <br>
            <br>
            <br>
            <span class='span-bold'>Sulfado Ferroso</span> em gotas, <br><span id='gotas' class='span-bold'>0 gotas</span> por dia, 2 vezes ao dia(após almoço e jantar)<br>
            <br>
            <span class='span-bold'>Albendazol</span> 15mg, <br><span id='comprimidos' class='span-bold'>0 comprimidos</span>(pode dissolver em copo como água ou suco)<br>
            <br>
            <br>
        </div>
    </div>
</div>
<script>
    var gotas = prompt('Quantidade de gotas:');
    var comprimidos = prompt('Quantidade de comprimidos:');
    document.getElementById("gotas").textContent = gotas + " gota" + (gotas > 1 ? "s" : "");
    document.getElementById("comprimidos").textContent = comprimidos + " comprimido" + (comprimidos > 1 ? "s" : "");
</script>