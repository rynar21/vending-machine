<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\behaviors\AttributeBehavior;

$this->title = 'Invoice';
?>

<div class="sale-record-receipt">

    <div class="header">
        <img src="<?= Url::base()?>/img/logo1.png" alt="logo" />

        <span class="store_details">
            Vending Machine
            <br/>
            <p>
                <?= $store_model->name.', '.$store_model->address ?>
            </p>
            <p>
                <?= $store_model->contact ?>
            </p>
        </span>
    </div>

    <hr/>

    <h2>
        RECEIPT
    </h2>

    <br/>

    <div>
        Transaction No.
    </div>

    <div>
        Purchased Time
    </div>

    <div>
        Item Purchased
    </div>

    <div>
        Quantity
    </div>

    <hr/>

    <div>
        Amount Paid
    </div>

    <hr/>
    <hr/>

</div>

<style>
.header{
    margin: 20px;
    padding: 20px;
    width: 90vw;
    height: 20vh;
    background-color: grey;
}

img{
    width: 10vw;
    height: 20vh;
    margin: 5px;
    padding: 10px;
    border: 1px solid red;
}

.store_details{
    position: absolute;
    margin: 2px;
    width: 30vw;
    border: 1px solid blue;
}

/* table {
  border-collapse: collapse;
  width: 100%;
  text-align: center;
}

table, th, td {
  border: 1px solid black;
}

th>a{
    text-decoration: none;
    color: black;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
} */

</style>
