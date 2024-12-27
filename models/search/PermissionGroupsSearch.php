<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PermissionGroups;

/**
 * PermissionGroupsSearch represents the model behind the search form of `app\models\PermissionGroups`.
 */
class PermissionGroupsSearch extends PermissionGroups
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'app_id', 'status'], 'integer'],
            [['name', 'code_permission_groups', 'detail_info'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $app_id = null)
    {
        $query = PermissionGroups::find();
        $query->where(['!=', 'status', PermissionGroups::STATUS_DELETED]);
        if ($app_id) {
            $query->andWhere(['app_id' => $app_id]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'app_id' => $this->app_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code_permission_groups', $this->code_permission_groups])
            ->andFilterWhere(['like', 'detail_info', $this->detail_info]);

        return $dataProvider;
    }
}
