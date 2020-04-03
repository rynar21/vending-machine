<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\behaviors\AttributeBehavior;

$this->title = 'Invoice';
?>

<header>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</header>

<div class="sale-record-receipt">

    <div class="header c-download b-color" style="margin: 10px 100px 5px 100px; padding: 20px;">
        <div class="container">
            <div class="row">

                <div class="col-sm-offset-1 col-sm-2 col-lg-offset-1 col-lg-2 text-center" style="height: 15%;">
                    <img src="<?php  echo Yii::getAlias('@static/images/logo1.png')?>" alt="logo" class="img-responsive"/>
                </div>

                <div class="col-sm-9 col-lg-9">
                    <p class="title">
                        Vending Machine
                    </p>
                    <p class="store-details">
                        <?= $store_model->name.', '.$store_model->address ?>
                    </p>
                    <p class="store-contact">
                        <?= $store_model->contact ?>
                    </p>
                </div>

            </div>
        </div>
    </div>

    <hr/>

    <div class="body-content container">
        <h2>
            RECEIPT
        </h2>

        <br/>

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
                <td><?= $item_model->name ?></td>
            </tr>
        	<tr>
                <td>Quantity: </td>
                <td> 1 </td>
            </tr>
        </table>

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

        <br/>
        <?= Html::a('Download as PDF', ['download', 'id' => $model->id], ['class' => 'btn btn-success btn-block b-color']) ?>
    </div>



</div>

<style>
.btn-success {
    background-color: #FE5802;
    border-color: #FE5802;
}
 .header{
    border: 0px solid red;
    color: #F0FFFF;
    background-color: #FE5802;
    border-radius: 5px;
}

p {
    margin: 5px 5px 5px 15px;
}

.title{
    font-size: 24px;
    font-weight: bold;
}

.store-details{
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-style: italic;
    font-size: 16px;

}

.store-contact{
    font-size: 14px;
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
    padding: 10px 25px;
}

/*  Define the background color for all the EVEN table columns  */
.transaction-details tr td:nth-child(even){
    background: #FE5802;
    text-align:right;
    color: #FFFFFF;
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
    padding: 10px 25px;
}

/*  Define the background color for all the EVEN table columns  */
.Total tr td:nth-child(even){
    background: #FE5802;
    text-align:right;
    font-size: 22px;
    color: #FFFFFF;
}

</style>
