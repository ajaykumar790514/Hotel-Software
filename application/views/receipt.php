
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$booking->guest_name?> <?=date('D, M d ,Y',strtotime($booking->start_date))?> - <?=date('D, M d ,Y',strtotime($booking->end_date))?></title>
    <!-- <link rel="stylesheet" href="style.css" media="all" /> -->
  </head>
  <body>
    <style type="text/css">
      .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 21cm;  
  height: 25.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width:100%;
  height: 100px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 105px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 500px;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
  margin: auto;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service{
  text-align: left;
}

table .desc {
  text-align: right;
  font-weight: 900;
}
table .remark {
  text-align: left;
}

table td {
  padding: 10px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
#printPageButton {
    cursor: pointer;
  }

@media print {
  #printPageButton {
    display: none;
  }
}
    </style>
    <header class="clearfix">
      <div style="text-align:left;">
        <img src="<?=IMGS_URL.$propmaster->logo?>" height="150px">
      </div>
      <h1>RECEIPT</h1>
      <div id="company" class="clearfix">
      <div style="font-weight: 600;"><span>Receipt No :-</span> <b style="font-size :1rem;">0000<?=$transaction->id?></b></div>
      <div style="font-weight: 600;"><span>Booking ID :-</span> <b style="font-size :1rem;"><?=$booking->id?></b></div>
      <div><?=$propmaster->propname?></div>
        <div><?=$propmaster->propname?></div>
        <div><?=$propmaster->address?></div>
        <div><?=$flat->contact_preson?></div>
        <div><?=$flat->contact_preson_mobile?></div>
        
      </div>
      <div id="project">
        <div><span>GUESTS NAME</span> : <?=$booking->guest_name?></div>
        <div><span>BOOKING FOR</span> : <?=date('D, M d, Y',strtotime($booking->start_date))?> - <?=date('D, M d, Y',strtotime($booking->end_date))?></div>
        <!-- <div><span>CONFIRMATION CODE</span> : <?=$booking->confirmation_code?></div> -->
        <div><span>MOBILE</span> : <?=$booking->contact?></div>
        <div><span>EMAIL</span> : <a href="mailto:<?=$booking->email?>"><?=$booking->email?></a></div>
        <div><span>BOOKING DATE</span> : <?=date('D, M d, Y',strtotime($booking->booking_date))?></div>
        <!-- <?php //if ($booking->pre_checkout!=0) { ?>
        <div><span>Checkout Date</span> : <?=date('D, M d, Y',strtotime($booking->checkout_date))?></div>
        <?php // } ?> -->
        <div>
          <span>PAYMENT STATUS</span> : <strong>
            <?=title('payment_status',$booking->payment_status,'id','status')?>
          </strong>
        </div>
      </div>
    </header>
    <main>
      <table class="table" style="width: 100%;">
        <thead>
          <tr>
            <th colspan="3">Price breakdown</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="service">Total</td>
            <td class="remark"></td>
            <td class="desc">₹ <?=$transaction->credit?></td>
          </tr>
          <tr>
           
            <td class="remark"><strong>Grand Total</strong></td>
            <td class="service"></td>
            <td class="desc">₹ <?=$transaction->credit?></td>
          </tr>
        </tbody>
      </table>
      <div id="logo" style="margin-top: 20px;">
        <img src="<?=$logo?>" height="">
      </div>
      <div>
        <button id="printPageButton" style="float: right;background-color: red; width:90px;height:30px;font-size:1.3rem;color:white;border-radius:10px" onClick="window.print();">Print</button>
      </div>
      
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>