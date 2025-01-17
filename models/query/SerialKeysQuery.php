<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\SerialKeys]].
 *
 * @see \app\models\SerialKeys
 */
class SerialKeysQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\SerialKeys[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\SerialKeys|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
