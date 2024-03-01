<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


require __DIR__ . '/vendor/autoload.php';

// $pdf = new TCPDF();                 // create TCPDF object with default constructor args
// $pdf->AddPage();                    // pretty self-explanatory
// $pdf->Write(1, 'Hello world');      // 1 is line height

// $pdf->Output('hello_world.pdf'); 

// ob_start();
// require_once 'tcpdf/tcpdf.php';
 
// // require "lib/functions.php";
// // $ob = new User();

// //  $invoice_details = mysql_query("SELECT tb_invoice.*,tb_user.fname FROM `tb_invoice` LEFT JOIN `tb_user` ON tb_user.id=tb_invoice.user_id WHERE invoice_no='".$_REQUEST['invoiceno']."'");

// //     $invoice_detailss = mysql_fetch_assoc($invoice_details);


// $html = '<html>
//         <thead></thead >
//         <tbody>
//         <table style="border:0px solid" width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
//           <tr>
//             <td height="20">
//             </td>
//           </tr>
//           <tr>
//             <td>
//               <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
//                 <tr style="background:#0788c5;">
//                   <td height="13">
//                   </td>
//                 </tr>
//                 <tr class="hiddenMobile">
//                   <td height="40">
//                   </td>
//                 </tr>
//                 <tr class="visibleMobile">
//                   <td height="30">
//                   </td>
//                 </tr>
//                 <tr>
//                   <td>
//                     <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
//                       <tbody>
//                         <tr>
//                           <td>
//                             <table width="320" border="0" cellpadding="0" cellspacing="0" align="left" class="col">
//                               <tbody>
//                                 <tr style="postion:relative">
//                                   <td align="left" style="font-size: 25px;color: #0788c5;">
//                                     <p style="font-size:11px;">
//                                       <strong> FIBRIN 
//                                       </strong>
//                                     </p>
//                                     <p style="font-size:9px;"> SERVICES & INSTALLATIONS  
//                                     </p>
//                                   </td>
//                                   <td align="center" style="font-size: 30px;color: #0788c5;"> 
//                                     <u>
//                                       <b> Invoice 
//                                         </u>
//                                       </t>
//                                 </tr>
//                               </tbody>
//                             </table>
//                             <table width="160" border="0" cellpadding="0" cellspacing="0" align="right" class="col">
//                               <tbody>
//                                 <tr class="visibleMobile">
//                                   <td height="20">
//                                   </td>
//                                 </tr>
//                                 <tr>
//                                   <td height="5">
//                                   </td>
//                                 </tr>
//                                 <tr>
//                                   <td style="font-size: 13px; color: #0EADF0; letter-spacing: -1px; font-family: "Open Sans", sans-serif; line-height: 1; vertical-align: top; text-align: right;">
//                                     <BR>
//                                       <span style="font-size: 15px;">
//                                         <br> Fibrinpay 
//                                       </span> 
//                                       <br> 
//                                       <span style="font-size: 11px;">Invoicing and payments
//                                       </span>
//                                       </td>
//                                 </tr>
//                                 <tr>
//                               </tbody>
//                             </table>
//                           </td>
//                         </tr>
//                       </tbody>
//                     </table>
//                     <hr style="border-top:1px solid #0888c4>';

// $html.='<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
//   <tbody>
//     <tr>
//       <td>
//         <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
//           <tbody>
//             <tr>
            
//             <tr>
//               <td>
//                 <table width="525" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
//                   <tbody>
//                     <tr style="background:#0788c5">
//                       <th style="font-size: 12px; font-family: "Open Sans", sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 6px 10px 7px 7px; border:1px solid #fff; color:#fff;" align="center">
//                         Sr No
//                       </th>
//                       <th style="font-size: 12px; font-family: "Open Sans", sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding:6px 10px 7px 7px; border:1px solid #fff; color:#fff;" width="52%" align="left">
//                         Item/Description
//                       </th>
//                       <th style="font-size: 12px; font-family: "Open Sans", sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 6px 10px 7px 7px; border:1px solid #fff; color:#fff;" align="center">
//                         Qty
//                       </th>
//                       <th style="font-size: 12px; font-family: "Open Sans", sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding:6px 10px 7px 7px; border:1px solid #fff; color:#fff;" align="left">
//                         <small>Unit Price</small>
//                       </th>
//                       <th style="font-size: 12px; font-family: "Open Sans", sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 6px 10px 7px 7px; border:1px solid #fff; color:#fff;" align="center">
//                         Discount [%]
//                       </th>
//                       <th style="font-size: 12px; font-family: "Open Sans", sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 6px 10px 7px 7px; border:1px solid #fff; color:#fff;" align="right">
//                         Amount
//                       </th>
//                     </tr>
//                     <tr>
//                       <td height="1" style="background: #bebebe;" colspan="6"></td>
//                     </tr>';
                   
//                     $invoice_item = mysql_query("SELECT * FROM invoice_cart_items WHERE invoice_number = '".$_REQUEST['invoiceno']."'"); 
//                    $i = 1;
//                    $sub_total=0;
//                     $total=0;
//                     $cgst=9;
//                     $sgst=9;
//                     $disc_amount=0;
//                    while($item = mysql_fetch_assoc($invoice_item)){
//                        $item_total=$item['unitprice']*$item['quantity'];
//                         $disc=($item_total * $item['discount'])/100;
//                          $disc_amount+=$disc;
//                         if($item['discount']>0){
//                             $item_total=($item_total - $disc);
//                         }
//                          $sub_total+=$item_total;
                   
//                    $html.='<tr>
//                       <td style="font-size: 12px; font-family: "Open Sans", sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0; border-left:1px solid #0788c5; border-right:1px solid #0788c5;" align="center">'.$i; $i++.'</td>
                     
//                       <td style="font-size: 12px; font-family: "Open Sans", sans-serif; color: #0EADF0;  line-height: 18px;  vertical-align: top; padding:10px 5px; " class="article">
//                         '.$item['name'].'
//                       </td>
//                       <td style="font-size: 12px; font-family: "Open Sans", sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0; border-left:1px solid #0788c5; border-right:1px solid #0788c5;" align="center">'.$item['quantity'].'</td>
                     
//                       <td style="font-size: 12px; font-family: "Open Sans", sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 5px; "><small>'.$item['unitprice'].'</small></td>
//                       <td style="font-size: 12px; font-family: "Open Sans", sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0; border-left:1px solid #0788c5; border-right:1px solid #0788c5;" align="center">'.$item['discount'].'%[₹'. $disc.']</td>
//                       <td style="font-size: 12px; font-family: "Open Sans", sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0; border-right:1px solid #0788c5;" align="center">₹'.$item_total.'</td>
//                     </tr>';
//                      } 
//                     $sgst_amount=($sub_total * $sgst)/100;
//                     $cgst_amount=($sub_total * $cgst)/100;
//                     $total=$sub_total+$sgst_amount+$cgst_amount;
                    
                    
//                     $html.='<tr>
//                       <td height="1" colspan="6" style="border-bottom:1px solid #e4e4e4"></td>
//                     </tr>
//                   </tbody>
//                 </table>
//               </td>
//             </tr>
//             <tr>
//               <td height="20"></td>
//             </tr>
//           </tbody>
//         </table>
//       </td>
//     </tr>
   
//   </tbody>
// </table>';

// $html.='<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
//   <tbody>
//     <tr>
//       <td>
//         <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
//           <tbody>
//             <tr>
//               <td>

//                 <!-- Table Total -->
//                 <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
//                   <tbody>
//                     <tr>
                        
//                       <td style="font-weight:600;font-size: 12px; font-family: "Open Sans", sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
//                         Subtotal
//                       </td>
//                       <td style="font-weight:600;font-size: 12px; font-family: "Open Sans", sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:center; white-space:nowrap;" width="80">
//                         '.$sub_total.'
//                       </td>
//                     </tr>
//                     <tr>
//                       <td style="font-size: 12px; font-family: "Open Sans", sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
//                         CGST ('.$invoice_detailss['cgst_percent'].'%)
//                       </td>
//                       <td style=" font-size: 12px; font-family: "Open Sans", sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:center; ">
//                        '.$cgst_amount.'
//                       </td>
//                     </tr>
//                     <tr>
//                       <td style="font-size: 12px; font-family: "Open Sans", sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
//                         SGST ('.$invoice_detailss['scgst_percent'].'%)
//                       </td>
//                       <td style=" font-size: 12px; font-family: "Open Sans", sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:center; ">
//                       '.$sgst_amount.'
//                       </td>
//                     </tr>
//                     <tr>
//                       <td style="font-size: 12px; font-family: "Open Sans", sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
//                         <strong>Grand Total</strong>
//                       </td>
//                       <td style="font-size: 12px; font-family: "Open Sans", sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:center; ">
//                         <strong>'.$total.'</strong>
//                       </td>
//                     </tr>
                    
//                     <tr>
//                       </td>
//                     </tr>
//                   </tbody>
//                 </table>
//                 <!-- /Table Total -->

//               </td>
//             </tr>
//           </tbody>
//         </table>
//       </td>
//     </tr>
//   </tbody>
// </table>';

// $html.='<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
//   <tbody>
//     <tr>
//       <td>
//         <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff">
//           <tbody>
//             <tr>
           
//             <tr class="visibleMobile">
//               <td height="40"></td>
//             </tr>
            
//           </tbody>
//         </table>
//       </td>
//     </tr>
//   </tbody>
// </table>

// <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable " bgcolor="#e1e1e1">
//  <tr>
//     <td>
//       <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable d-print-none" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
//         <tr>
//           <td>
//             <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
//               <tbody>
//                 <tr>
//                   <td  style="font-size: 12px; color: #5b5b5b; font-family: "Open Sans", sans-serif; line-height: 18px; vertical-align: top; text-align: right;"><BR>
//                   <form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_LXRhcGwBrXdBik" async> </script> </form><br>Download invoice</br>
                   
                    
//                   </td>
                  
//                 </tr>
//               </tbody>
//             </table>
//           </td>
//         </tr>
       

//       </table>
//     </td>
//   </tr>
  
//   <tr>
//     <td>
//       <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
//         <tr>
//           <td>
//             <table width="480" border="0" cellpadding="0" cellspacing="0" align="center" class="fullPadding">
//               <tbody>
//                 <tr>
                
//                   <td width="180" style="font-size: 12px; color: #5b5b5b; font-family: "Open Sans", sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                  
//                    <strong><BR>Terms & Conditions</strong><br>
//                    <p style="font-size:11px">1. This bill must be settled as per agreed terms<br>
//                    <p style="font-size:11px">2. Cash payment must be made against company receipt only
//                     <p>'.$invoice_detailss['terms_condition'].'</p>
                    
//                   </td>
//                   <td width="120" style="font-size: 12px; color: #5b5b5b; font-family: "Open Sans", sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                  
//                   </td>
//                 </tr>
//               </tbody>
//             </table>
//           </td>
//         </tr>
//         <tr class="spacer">
//           <td height="50"></td>
//         </tr>

//       </table>
//     </td>
//   </tr>
//   <tr>
//     <td height="20"></td>
//   </tr>
// </table>
// </tbody>
// </html>';

// // echo $html; die;

$html_ = '<html>
<tbody>
        <table style="border:0px solid" width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
          <tr>
            <td height="20">
            </td>
          </tr>
          <tr>
            <td>
              <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
                <tr style="background:#0788c5;">
                  <td height="13">
                  </td>
                </tr>
                <tr class="hiddenMobile">
                  <td height="40">
                  </td>
                </tr>
                <tr class="visibleMobile">
                  <td height="30">
                  </td>
                </tr>
                </table>
                </td>
                </tr>
                </table>
</html>';

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, 'mm', 'A4', true, 'UTF-8', false);

                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);

                $pdf->SetTitle('Receipt');
                $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

                $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                $pdf->SetMargins(5, 3, 5);
                $pdf->SetHeaderMargin(3);
                $pdf->SetFooterMargin(1);

                $pdf->SetAutoPageBreak(TRUE, 1);

                $pdf->AddPage('P');
                //echo "<pre>";print_r($html); exit;
                $pdf->writeHTML($html_, true, false, true, false, '');
// ob_end_clean();

$pdf->Output('Invoice.pdf', 'I');
?>
