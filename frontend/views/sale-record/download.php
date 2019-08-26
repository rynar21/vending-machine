<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\behaviors\AttributeBehavior;
?>
<style>
.header > hr{
    border: 1px #D4D4D4 solid;
    background-color: #D4D4D4;
}

.title{
    font-size: 24px;
    font-weight: bold;
}

.store-details{
    font-style: italic;
    font-size: 16px;
}

.store-contact{
    font-size: 14px;
}

.body-content{
    margin: 10px 20px;
}

.transaction-details{
    width: 100%;
    border-collapse:collapse;
}

.transaction-details td{
    padding: 7px;
    margin: 5px 0px;
}

.transaction-details tr td:nth-child(odd){
    text-align: left;
    width: 30%;
    font-weight: bold;
    color: #908989;
    padding: 10px 0px;
}

/*  Define the background color for all the EVEN table columns  */
.transaction-details tr td:nth-child(even){
    /* background: #dae5f4; */
    text-align:right;
}

.Total{
    width: 100%;
    border-collapse:collapse;
}

.Total td{
    padding: 7px;
    margin: 5px 0px;
}

.Total tr td:nth-child(odd){
    text-align: left;
    width: 30%;
    font-weight: bold;
    color: black;
    padding: 10px 0px;
}

/*  Define the background color for all the EVEN table columns  */
.Total tr td:nth-child(even){
    background: #dae5f4;
    text-align:right;
    font-size: 22px;
}

</style>

<div class="header">
        <div style="text-align:center; margin:5px;">
            <img src="<?= Url::base()?>/img/logo1.png" alt="logo" class="img-responsive" height="55"/>
        </div>

        <div style="text-align:center;">
            <div class="title">
                <b>Vending Machine</b>
            </div>
            <div class="store-details">
                <b><?= $store_model->name?></b>,
                <?= $store_model->address ?>
            </div>
            <div class="store-contact">
                <?= $store_model->contact ?>
            </div>
        </div>

        <hr/>
</div>



    <div class="body-content">
        <h2>
            RECEIPT
        </h2>

        <table class="transaction-details">
            <tr>
                <td>Transaction Status: </td>
                <td>Payment Successful</td>
            </tr>
        	<tr>
                <td>Transaction No.: </td>
                <td> <?= $model->id ?> </td>
            </tr>
        	<tr>
                <td>Purchased Time: </td>
                <td> <?= Yii::$app->formatter->asDateTime($model->updated_at) ?></td>
            </tr>
        	<tr>
                <td>Purchsed Item: </td>
                <td><b><?= $item_model->name ?></b></td>
            </tr>
        	<tr>
                <td>Quantity: </td>
                <td> 1 </td>
            </tr>
        </table>

        <br/>
        <hr/>
        <table class="Total">
        	<tr>
                <td>Total Paid Amount: </td>
                <td class="price">
                    <b> <?= $model->pricing ?> </b>
                </td>
            </tr>
        </table>

        <hr/>
        <hr/>

    </div>
