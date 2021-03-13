<?php
/**
 * @var BonusCodesSearch $model
 * @var CActiveDataProvider $dataProvider
 * @var BonusCodes[] $data
 * @var CActiveForm $form
 */

use app\modules\backend\models\search\BonusCodesSearch;

$title_ = 'Бонус - коды';
$this->pageTitle = $title_;
$this->breadcrumbs = [$title_];
?>

<?php $this->widget('app.widgets.FlashMessages.FlashMessages') ?>

<?php $form = $this->beginWidget('CActiveForm', [
    'id' => $this->getId() . '-form',
    'method' => 'GET',
    'action' => ['index'],
]) ?>

<?php echo CHtml::link('Создать', ['form'], ['class' => 'btn btn-primary btn-block']) ?>
<table class="table">
    <colgroup>
        <col style="width: 5%;">
        <col style="width: 20%;">
        <col>
        <col style="width: 10%;">
        <col style="width: 14%;">
        <col style="width: 14%;">
        <col style="width: 10%;">
    </colgroup>
    <thead>
    <tr>
        <th>ID</th>
        <th>Код</th>
        <th>Бонус</th>
        <th>Лимит</th>
        <th>Кол-во использований</th>
        <th>Статус</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?php echo $form->textField($model, 'id', ['class' => 'form-control input-sm']) ?></td>
        <td><?php echo $form->textField($model, 'code', ['class' => 'form-control input-sm']) ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td><?php echo $form->dropDownList($model, 'status', ActiveRecord::getStatusListWithoutDelete(), ['class' => 'form-control input-sm', 'empty' => '-- выбрать --']) ?></td>
        <td>
            <button type="submit" class="btn btn-primary glyphicon glyphicon-search btn-sm" title="Искать"
                    rel="tooltip"></button>
            <?php echo CHtml::link('', ['index'], ['class' => 'btn btn-default glyphicon glyphicon-ban-circle btn-sm', 'title' => 'Сбросить', 'rel' => 'tooltip']) ?>
        </td>
    </tr>
    <?php if ($data = $dataProvider->getData()) { ?>
        <?php foreach ($data as $row) { ?>
            <tr>
                <td><?php echo $row->id ?></td>
                <td><?php echo $row->code ?></td>
                <td>
                    <?php if ($row->bonusInfo !== null) { ?>
                        <?php echo CHtml::link(CHtml::encode($row->bonusInfo->title), ['/backend/bonuses/form', 'id' => $row->bonusInfo->getPrimaryKey()], ['target' => '_blank']) ?>
                    <?php } else { ?>
                        Бонус не найден
                    <?php } ?>
                </td>
                <td><?php echo $row->limit ?></td>
                <td><?php echo count($row->bonusLog) ?></td>
                <td><?php $this->widget('app.widgets.Status.Status', [
                        'status' => $row->status,
                        'statusText' => $row->getStatus()
                    ]) ?></td>
                <td>
                    <ul class="actions list-unstyled">
                        <li><?php echo CHtml::link('', ['form', 'id' => $row->id], ['class' => 'glyphicon glyphicon-pencil', 'title' => 'Редактировать', 'rel' => 'tooltip']) ?></li>
                        <li><?php echo CHtml::link('', ['allow', 'id' => $row->id], ['class' => ($row->isStatusOn() ? 'glyphicon glyphicon-eye-close' : 'glyphicon glyphicon-eye-open'), 'title' => ($row->isStatusOn() ? 'Выключить' : 'Включить'), 'rel' => 'tooltip']) ?></li>
                        <li><?php echo CHtml::link('', ['del', 'id' => $row->id], ['class' => 'glyphicon glyphicon-remove js-confirm-del', 'title' => 'Удалить', 'rel' => 'tooltip']) ?></li>
                    </ul>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td colspan="7">Нет данных.</td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php $this->endWidget() ?>

<?php $this->widget('CLinkPager', [
    'pages' => $dataProvider->getPagination(),
]) ?>
