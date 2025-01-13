<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Roles;
use Codeception\Lib\Interfaces\API;

/**
 * RolesSearch represents the model behind the search form of `app\models\Roles`.
 */
class RolesSearch extends Roles
{

    public $appName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'app_id', 'status'], 'integer'],
            [['name', 'code_roles', 'detail_info', 'permission_json', 'appName'], 'safe'],
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
    public function search($params, $app_id = null, $deleted = false)
    {
        $query = Roles::find();
        $query->joinWith('apps');
        if ($deleted) {
            $query->where(['roles.status' => Roles::STATUS_DELETED]);
        } else {
            $query->where(['!=', 'roles.status', Roles::STATUS_DELETED]);
        }
        if ($app_id) {
            $query->andWhere(['app_id' => $app_id]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['appName'] = [
            'asc' => ['apps.name' => SORT_ASC],
            'desc' => ['apps.name' => SORT_DESC],
        ];

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
            'roles.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'roles.name', $this->name])
            ->andFilterWhere(['like', 'code_roles', $this->code_roles])
            ->andFilterWhere(['like', 'roles.detail_info', $this->detail_info])
            ->andFilterWhere(['like', 'permission_json', $this->permission_json])
            ->andFilterWhere(['like', 'apps.name', $this->appName]);

        return $dataProvider;
    }
}
