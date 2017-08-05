<?php

namespace app\models;

use Yii;
use app\classes\Caption;
use app\classes\SetFlashCRUD;

/**
 * This is the model class for table "{{%account}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $current_sum
 * @property integer $state
 * @property integer $user_id
 *
 * @property Expense[] $expenses
 * @property ExpenseTemplate[] $expenseTemplates
 * @property Income[] $incomes
 * @property IncomeCategory[] $incomeCategories
 * @property User $user
 * @property AccountMove[] $accountMoves
 * @property AccountMove[] $accountMoves0
 */
class Account extends \yii\db\ActiveRecord {

    const STATE_ACTIVE = 0;
    const STATE_CLOSE = 1;
    const SHOW_PERMISSION = 0;
    const SHOW_ALL = 1;
    const SHOW_USER = 2;
    
    

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%account}}';
    }

    public function behaviors() {
        return [
            // Сообщения действий CRUD
            SetFlashCRUD::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'state', 'user_id', 'current_sum'], 'required'],
            [['current_sum'], 'number'],
            [['state', 'user_id'], 'integer'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'current_sum' => 'Текущая сумма',
            'state' => 'Состояние',
            'user_id' => 'Пользователь',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenses() {
        return $this->hasMany(Expense::className(), ['account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenseTemplates() {
        return $this->hasMany(ExpenseTemplate::className(), ['account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncomes() {
        return $this->hasMany(Income::className(), ['account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncomeCategories() {
        return $this->hasMany(IncomeCategory::className(), ['account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountMoves() {
        return $this->hasMany(AccountMove::className(), ['account_from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountMoves0() {
        return $this->hasMany(AccountMove::className(), ['account_to' => 'id']);
    }

    //Мои статические методы для списков

    /**
     * Возвращает список Пользователей и их Кошельков
     */
    public static function findAllAndUserName($show = Self::SHOW_PERMISSION) {
        if ($show == Self::SHOW_USER) {
            $sql = 'SELECT a.id as id, a.name FROM {{%account}} a, db1_user us
            where a.user_id = us.id  and a.state = 0
            and a.user_id = ' . Yii::$app->user->identity->id . ' order by us.username, a.name';
        } else if ($show == Self::SHOW_ALL) {
            $sql = 'SELECT a.id as id, concat(a.name, " (", us.username, ")") as name
            FROM {{%account}} a, db1_user us
            where a.user_id = us.id  and a.state = 0 order by us.username, a.name';
        } else
        if (Yii::$app->user->can('show_all')) {
            $sql = 'SELECT  a.id as id, concat(a.name, " (", us.username, ")") as name
            FROM {{%account}} a, db1_user us
            where a.user_id = us.id  and a.state = 0 order by us.username, a.name';
        } else {
            $sql = 'SELECT a.id as id, a.name FROM {{%account}} a, db1_user us
            where a.user_id = us.id
            and a.state = 0  and a.user_id = ' . Yii::$app->user->identity->id . ' order by us.username, a.name';
        }
        return self::findBySql($sql)->all();
    }

    /**
     * Возвращает  Кошельков пользователя и суммы в них
     */
    public static function findAllAndCurrentSum() {

        $sql = 'SELECT a.id AS id, CONCAT( a.name,  " - ", a.current_sum ) AS name
                FROM {{%account}} a
                WHERE a.state =0
                AND a.user_id = ' . Yii::$app->user->identity->id
                . ' ORDER BY a.name';

        return self::findBySql($sql)->all();
    }


}
