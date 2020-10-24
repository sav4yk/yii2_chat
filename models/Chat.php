<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property int $user_id
 * @property string $message
 * @property int|null $visible
 * @property string|null $created_at
 *
 * @property User $user
 */
class Chat extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * @return array|array[]
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                // если вместо метки времени UNIX используется datetime:
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'required'],
            [['created_at'], 'safe'],
            [['message'], 'string', 'max' => 255],

        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Show and hide message in chat
     *
     * @return bool
     */
    public function setVisible()
    {
        if (Yii::$app->user->identity->isAdmin) {
            $this->visible = !$this->visible;
            return $this->save(false);
        }
    }
}
