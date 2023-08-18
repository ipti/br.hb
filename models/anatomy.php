<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "anatomy".
 *
 * @property integer $id
 * @property integer $student
 * @property double $weight
 * @property double $height
 * @property string $date
 *
 * @property Student $students
 */
class anatomy extends \yii\db\ActiveRecord
{
    public const DESNUTRIDO    = -1;
    public const NORMAL        = 0;
    public const SOBREPESO     = 1;
    public const OBESIDADE     = 2;
    public const OBESIDADE_MORBIDA = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'anatomy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [['student','weight', 'height', 'date'], 'required'],
            [['student'], 'integer'],
            [['weight', 'height'], 'number'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'student' => Yii::t('app', 'Student'),
            'weight' => Yii::t('app', 'Weight'),
            'height' => Yii::t('app', 'Height'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasOne(student::class, ['id' => 'student']);
    }

    public function IMC()
    {
        return round($this->weight/($this->height*$this->height), 2);
    }

    public function IMCSituation()
    {
        if($this->IMC() <  19) {
            return anatomy::DESNUTRIDO;
        } elseif($this->IMC() >= 19 && $this->IMC() < 24.9) {
            return anatomy::NORMAL;
        } elseif($this->IMC() >= 25 && $this->IMC() < 29.9) {
            return anatomy::SOBREPESO;
        } elseif($this->IMC() >= 30 && $this->IMC() < 39.9) {
            return anatomy::OBESIDADE;
        } elseif($this->IMC() >= 40) {
            return anatomy::OBESIDADE_MORBIDA;
        } else {
            return null;
        }
    }

    public function classificarIMCInfantil($imc, $idade, $genero)
    {
        // Tabelas de classificação do IMC para crianças de acordo com a OMS
        $tabelas_IMC = [
            // Meninos (0 a 5 anos)
            'masculino' => [
                0 => [15.5, 17.5, 18.5, 21, 23],
                1 => [14.5, 16.5, 17.5, 20, 22],
                2 => [14, 16, 17, 19, 21],
                3 => [13.5, 15.5, 16.5, 18.5, 20.5],
                4 => [13.1, 15, 16, 18, 20],
                5 => [12.7, 14.5, 15.5, 17.5, 19.5],
                6 => [12.2, 14.1, 15.4, 17.9, 21.4],
                7 => [11.8, 13.6, 14.9, 17.3, 20.8],
                8 => [11.6, 13.4, 14.7, 17.1, 20.6],
                9 => [11.4, 13.2, 14.5, 16.9, 20.4],
                10 => [11.3, 13.1, 14.4, 16.8, 20.3],
                11 => [11.2, 13, 14.3, 16.7, 20.2],
                12 => [11.2, 13, 14.3, 16.7, 20.2],
                13 => [11.1, 12.9, 14.2, 16.6, 20.1],
                14 => [11.1, 12.9, 14.2, 16.6, 20.1],
                15 => [11, 12.8, 14.1, 16.5, 20],
                16 => [11, 12.8, 14.1, 16.5, 20],
                17 => [11, 12.8, 14.1, 16.5, 20],
                18 => [11, 12.8, 14.1, 16.5, 20],
                19 => [11, 12.8, 14.1, 16.5, 20],
            ],

            // Meninas (0 a 5 anos)
            'feminino' => [
                0 => [15, 17, 18, 20, 22],
                1 => [14, 16, 17, 18.8, 20.8],
                2 => [13.5, 15.5, 16.5, 18.3, 20.3],
                3 => [13, 15, 16, 17.8, 19.8],
                4 => [12.7, 14.7, 15.7, 17.5, 19.5],
                5 => [12.4, 14.4, 15.4, 17.2, 19.2],
                6 => [12.1, 14, 15.3, 17.7, 21.3],
                7 => [11.7, 13.6, 14.9, 17.3, 20.8],
                8 => [11.5, 13.4, 14.7, 17.1, 20.6],
                9 => [11.3, 13.2, 14.5, 16.9, 20.4],
                10 => [11.2, 13.1, 14.4, 16.8, 20.3],
                11 => [11.1, 13, 14.3, 16.7, 20.2],
                12 => [11.1, 13, 14.3, 16.7, 20.2],
                13 => [11, 12.9, 14.2, 16.6, 20.1],
                14 => [11, 12.9, 14.2, 16.6, 20.1],
                15 => [11, 12.8, 14.1, 16.5, 20],
                16 => [11, 12.8, 14.1, 16.5, 20],
                17 => [11, 12.8, 14.1, 16.5, 20],
                18 => [11, 12.8, 14.1, 16.5, 20],
                19 => [11, 12.8, 14.1, 16.5, 20],
            ],
        ];

        // Encontra as faixas de classificação com base na idade e no gênero
        $faixas = $tabelas_IMC[$genero][$idade];

        // Classifica o IMC com base nas faixas definidas
        if ($imc < $faixas[0]) {
            return 'Muito abaixo do peso';            
        } elseif ($imc < $faixas[1]) {
            return 'Abaixo do peso';
        } elseif ($imc < $faixas[2]) {
            return 'Peso normal';
        } elseif ($imc < $faixas[3]) {
            return 'Sobrepeso';
        } else {
            return 'Obesidade';
        }
    }
}
