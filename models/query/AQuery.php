<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\LogActivity]].
 *
 * @see \app\models\LogActivity
 */
class AQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\LogActivity[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\LogActivity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
