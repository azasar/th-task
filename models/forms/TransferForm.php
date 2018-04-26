<?php

namespace app\models\forms;

use app\models\User;
use Yii;
use yii\base\Model;

/**
 * TransferForm is the model behind the login form.
 *
 */
class TransferForm extends Model
{
    public $recipientUsername;
    public $amount;
    /**
     * @var User
     */
    private $_user;

    public function __construct($user, array $config = [])
    {
        $this->_user = $user;
        parent::__construct($config);
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['recipientUsername', 'amount'], 'required'],
            ['amount', 'double'],
            ['amount', 'compare', 'compareValue' => 0, 'operator' => '>'],
            [
                'amount',
                'compare',
                'compareValue' => $this->_user->getAvailableBalanceForTransfer(),
                'operator' => '<=',
                'message' => 'Sorry, but your balance is not enough, you have '
                            . Yii::$app->formatter->asCurrency($this->_user->getAvailableBalanceForTransfer())
                            . ' for transfer'
            ],
            [
                'amount',
                'match',
                'pattern' => '/^\d+(\.\d{1,2})?$/',
                'message' => 'Amount can contain only 2 digits after precision'
            ],
            [
                'recipientUsername',
                'compare',
                'compareValue' => $this->_user->username,
                'operator' => '!=',
                'message' => 'You can not transfer money to yourself'
            ],
        ];
    }
}
