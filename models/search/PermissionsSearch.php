<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Permissions;

/**
 * PermissionsSearch represents the model behind the search form of `app\models\Permissions`.
 */
class PermissionsSearch extends Permissions
{
    public $appName;
    public $permissionGroupName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'app_id', 'permission_group_id', 'status'], 'integer'],
            [['name', 'code_permissions', 'detail_info', 'appName', 'permissionGroupName'], 'safe'],
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
        $query = Permissions::find();
        $query->joinWith(['apps', 'permissionGroups']);
        if ($deleted) {
            $query->where(['permissions.status' => Permissions::STATUS_DELETED]);
        } else {
            $query->where(['!=', 'permissions.status', Permissions::STATUS_DELETED]);
        }
        if ($app_id) {
            $query->andWhere(['permissions.app_id' => $app_id]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['appName'] = [
            'asc' => ['apps.name' => SORT_ASC],
            'desc' => ['apps.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['permissionGroupName'] = [
            'asc' => ['permissionGroups.name' => SORT_ASC],
            'desc' => ['permissionGroups.name' => SORT_DESC],
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
            'permissions.app_id' => $this->app_id,
            'permission_group_id' => $this->permission_group_id,
            'permissions.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'permissions.name', $this->name])
            ->andFilterWhere(['like', 'code_permissions', $this->code_permissions])
            ->andFilterWhere(['like', 'permissions.detail_info', $this->detail_info])
            ->andFilterWhere(['like', 'apps.name', $this->appName])
            ->andFilterWhere(['like', 'permission_groups.name', $this->permissionGroupName]);

        return $dataProvider;
    }
}
