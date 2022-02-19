<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <title>Generate Invoice</title>
      <style>
        .result{
         color:red;
        }
        td
        {
          text-align:center;
        }
      </style>
   </head>
   <body>
      <section class="mt-3">
         <div class="container-fluid">
         <h4 class="text-center" style="color:green"> Invoice </h4>
               <a style= "margin-top: 6px;margin-left: 3px;color: white;background:#0066A2;border-style:outset;border-color:#0066A2;height:30px;margin-left: 1077px;width:75px;text-shadow:none;text-align:center;text-decoration: none;" href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>

         {{-- <h6 class="text-center"> Shine Metro Mkadi Naka (New - Delhi)</h6> --}}
         
         <div class="row">
            <div class="col-md-12 mt-4 " >
               <table id= "tbl" class="table" style="background-color:#e0e0e0;" >
                 
                  <thead>
                 
                  <tr>
                     <th colspan="6" class="text-center"><h5>Receipt</h5></th>
                  </tr>
                     <tr>
                        <th>Name</th>
                        <th style="width: 31%">Quantity</th>
                        <th>Unit Price</th>
                        <th>Tax</th>
                        <th>Total</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr class="fieldGroup">
                        <td style="width:24%">
                        <input type="text" id="name-0" name="name[]" class="form-control">

                        </td>
                        <td style="width:1%">
                          <input type="text" id="qty-0" name="qty[]" class="form-control allow_decimal" onKeyPress="return isNumberKey(event)" onchange="upd_art(0);">
                        </td>
                        <td style="width:18%">
                           <input type="text" id="price-0" name="price[]" class="form-control allow_decimal" onKeyPress="return isNumberKey(event)" onchange="upd_art(0);">
                        </td>
                        <td style="width:15%">
                          <input type="hidden" name="row_cnt[]" id="row_cnt" class="row_cnt_cls" value="0" >
                          <select id="tax-0" name="tax[]" class="form-control" onchange="upd_art(0);">
                             <option value="0">0%</option>
                             <option value="1">1%</option>
                             <option value="5">5%</option>
                             <option value="10">10%</option>
                          </select>
                          
                        </td>
                        <td style="width:20%">
                          <input type="text" id="total-0" name="total[]" class="form-control total" readonly>
                        </td>
                       <td class="btn_hide"><button class="btn btn-info" id="addProduct"><i class="fa fa-plus"></i></button></td>

                     </tr>
                    
                     <tr class="calculations">
                        <td colspan="3"></td>
                        <td style="text-align: right;"><strong>Sub Total without Tax:  ₹ </strong> </td>
                        <td id="sub_tot_without_tax" style="font-weight: bold;"> </td>
                     </tr>  
                     <tr class="calculations">
                        <td colspan="3"></td>
                        <td style="text-align: right;"><strong>Discount:  ₹ </strong> </td>
                        <td><strong><input type="text" id="discount_val" name="discount_val" class="form-control allow_decimal"> </strong> </td>
                     </tr> 
                     <tr class="calculations">
                        <td colspan="3"></td>
                        <td style="text-align: right;"><strong>Sub Total with Tax : ₹ </strong> </td>
                        <td id="sub_tot_with_tax" style="font-weight: bold;"> </td>
                     </tr> 
                     <tr class="calculations">
                        <td colspan="3"></td>
                        <td style="text-align: right;"><strong>Total: ₹ </strong> </td>
                        <td id="grand_tot" style="font-weight: bold;"> </td>
                     </tr> 
                  </tbody>
               </table>
               <div role="alert" id="errorMsg" class="mt-5" >
                 <!-- Error msg  -->
              </div>
               <div role="alert" id="print" class="mt-5" style="text-align: center;">
                   <button id="print" class="btn btn-success" >Generate Invoice</button>
              </div>
            </div>
    </div>
    
      </section>
   </body>
</html>
<script>
    $(document).ready(function(){
   
   $(".allow_decimal").on("input", function(evt) {
      var self = $(this);
      self.val(self.val().replace(/[^0-9\.]/g, ''));
      if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
      {
      evt.preventDefault();
      }
   });

   //add
   var i = 0;

  $("#discount_val").change(function() {
   var discount = parseFloat($("#discount_val").val()).toFixed(2); 
   var sub_tot_tax = $("#sub_tot_with_tax").html();
   if(sub_tot_tax!="")
   {
      if(discount!="")
      {
         if(discount>sub_tot_tax)
         {
            alert("Discount amount exceeded.");
            $("#discount_val").val('');
            $("#grand_tot").html(parseFloat(sub_tot_tax).toFixed(3));
         }
         else
         {
            grand_total = (sub_tot_tax-discount);
            $("#grand_tot").html(parseFloat(grand_total).toFixed(3));
         }
         
      }
      else
      {
         $("#grand_tot").html(parseFloat(sub_tot_tax).toFixed(3));
      }
   }
  });
  $('#addProduct').click(function() {
    
    i++;
    var $tableBody = $('#tbl').find("tbody"),
      $trLast = $tableBody.find("tr.fieldGroup:last"),
      $trNew = '<tr id="row' + i + '"><td style="width:24%"><input type="text" id="name-'+i+'" name="name[]" class="form-control"></td><td style="width:1%"><input type="text" id="qty-' + i + '" name="qty[]" class="form-control allow_decimal" onKeyPress="return isNumberKey(event)" onchange="upd_art(' + i + ');"></td><td style="width:18%"><input type="text" id="price-' + i + '" name="price[]" class="form-control allow_decimal" onKeyPress="return isNumberKey(event)" onchange="upd_art(' + i + ');"></td><td style="width:15%"><input type="hidden" name="row_cnt[]" id="row_cnt" class="row_cnt_cls" value="'+i+'"><select id="tax-' + i + '" name="tax[]" class="form-control" onchange="upd_art(' + i + ');"><option value="0">0%</option><option value="1">1%</option><option value="5">5%</option><option value="10">10%</option></select></td><td style="width:20%"><input type="text" id="total-' + i + '" name="total[]" class="form-control total" readonly></td><td class="btn_hide"><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove"><i class="fa fa-times" aria-hidden="true"></i></button></td></tr>';
   
      $trLast.after($trNew);
  });
  $(document).on('click', '.btn_remove', function() {
    var button_id = $(this).attr("id");
    $('#row' + button_id + '').remove();
  });
  
$("#print").click(function(){
      var empty = 0;
      var html = '';
      html +='<table id="tbl" class="table" cellspacing="0" cellpadding="10" style="background-color:#e0e0e0;">';
      html +=' <thead>';
      html +=' <tr>';
      html +=' <th colspan="6" class="text-center"><h5>Receipt</h5></th>';
      html +=' </tr>';
      html +=' <tr>';
      html +=' <th>Name</th>';
      html +='  <th style="width: 31%">Quantity</th>';
      html +='  <th>Unit Price</th>';
      html +='  <th>Tax</th>';
      html +='  <th>Total</th>';
      html +='  </tr>';
      html +='  </thead>';
      html +='  <tbody>';

            $(".row_cnt_cls").each(function(){
                           var row_cnt = $(this).val();
                           var total = 0;
                           var name = $('#name-' + row_cnt).val();
                           var qty = $('#qty-' + row_cnt).val();
                           var price = $('#price-' + row_cnt).val();
                           var taxrate = $('#tax-' + row_cnt).val();
                           var total = $('#total-' + row_cnt).val();

                           if(name=="" || qty=="" || price=="")
                           {
                              empty+=1;
                           }
                              html +='     <tr class="fieldGroup">';
                              html +='        <td style="width:24%;text-align: center;text-transform:capitalize;">';
                              html +=name;

                                 html +='     </td>';
                                 html +='   <td style="width:1%;text-align: center;">';
                                 html +=qty;
                                 html +='  </td>';
                                 html +='  <td style="width:18%;text-align: center;">';
                                 html +=price;
                                 html +='  </td>';
                                 html +='  <td style="width:15%;text-align: center;">';
                                 html +=taxrate;
                                    
                                 html +='  </td>';
                                 html +=' <td style="width:20%;text-align: center;">';
                                 html +=total;
                                 html +='  </td>';
                                 html +='  </tr>';
                           
   
            });
            var sub_tot_without_tax = $('#sub_tot_without_tax').html();
            var discount_val        = $('#discount_val').val();
            var sub_tot_with_tax    = $('#sub_tot_with_tax').html();
            var grand_tot           = $('#grand_tot').html();

            
               
            html +=' <tr class="calculations">';
            html +='  <td colspan="3"></td>';
            html +=' <td style="text-align: right;padding-left:10px;padding-right:10px;"><strong>Sub Total without Tax:  ₹ </strong> </td>';
            html +='  <td id="sub_tot_without_tax" style="font-weight: bold;text-align: center;">'+sub_tot_without_tax+'</td>';
            html +='  </tr>  ';
            html +='  <tr class="calculations">';
            html +='    <td colspan="3"></td>';
            html +='    <td style="text-align: right;padding-left:10px;padding-right:10px;"><strong>Discount:  ₹ </strong> </td>';
            html +='   <td style="font-weight: bold;text-align: center;">'+discount_val+'</td>';
            html +='  </tr> ';
            html +='  <tr class="calculations">';
            html +='     <td colspan="3"></td>';
            html +='    <td style="text-align: right;padding-left:10px;padding-right:10px;"><strong>Sub Total with Tax : ₹ </strong> </td>';
            html +='     <td id="sub_tot_with_tax" style="font-weight: bold;text-align: center;">'+sub_tot_with_tax+'</td>';
            html +='   </tr> ';
            html +='  <tr class="calculations">';
            html +='     <td colspan="3"></td>';
            html +='     <td style="text-align: right;padding-left:10px;padding-right:10px;"><strong>Total: ₹ </strong> </td>';
            html +='     <td id="grand_tot" style="font-weight: bold;text-align: center;">'+grand_tot+'</td>';
            html +='  </tr> ';
            html +='  </tbody>';
            html +='   </table>';
            if(empty>0)
            {
               alert("Please fill the details");
            }
            else
            {
               var divToPrint = document.getElementById('tbl');
               var htmlToPrint = '' +
                  '<style type="text/css">' +
                  'table th, table td {' +
                  'border:1px solid #000;' +
                  'padding;0.5em;' +
                  '}' +
                  '</style>';
               htmlToPrint += html;
               newWin = window.open("");
               newWin.document.write("<h3 align='center'>INVOICE</h3>");
               newWin.document.write(htmlToPrint);
               newWin.print();
               newWin.close();
            }
   });
});
function upd_art(i) {
   var total = 0;
   var qty = $('#qty-' + i).val();
   var price = $('#price-' + i).val();
   var taxrate = $('#tax-' + i).val();

   var totNumber = (qty * price);
   var tot = totNumber.toFixed(2);

   if(taxrate==0)
   {
   var tax = 0 ;
   }
   else
   {
   var tax = ((tot*taxrate)/100);
   }
   var tot_with_tax  = parseFloat(tot)+parseFloat(tax);
   $('#total-' + i).val(tot_with_tax);

   var sub_tot_tax =0;
   var sub_tot_notax =0;
$(".row_cnt_cls").each(function(){
   var row_cnt = $(this).val();
   var total = 0;
   var qty = $('#qty-' + row_cnt).val();
   var price = $('#price-' + row_cnt).val();
   var taxrate = $('#tax-' + row_cnt).val();

   var totNumber = (qty * price);
   var tot = parseFloat(totNumber.toFixed(2));

   if(taxrate==0)
   {
   var tax = 0 ;
   }
   else
   {
   var tax = ((tot*taxrate)/100);
   }
   var tot_with_tax  = parseFloat(tot)+parseFloat(tax);
   sub_tot_notax+=tot;
   sub_tot_tax+=tot_with_tax;
    
});
console.log(sub_tot_tax);
$("#sub_tot_without_tax").html(parseFloat(sub_tot_notax).toFixed(3));
$("#sub_tot_with_tax").html(parseFloat(sub_tot_tax).toFixed(3));
var discount = $("#discount_val").val();
if(discount!="")
{
   if(discount>sub_tot_tax)
   {
      alert("Discount amount exceeded.");
      $("#discount_val").val('');
   }
   else
   {
      grand_total = (sub_tot_tax-discount);
      $("#grand_tot").html(parseFloat(grand_total).toFixed(3));
   }
   
}
else
{
   $("#grand_tot").html(parseFloat(sub_tot_tax).toFixed(3));
}
    
}
function isNumberKey(e)
{
      var key = e.charCode || e.keyCode || 0;
      if(!(key == 8 || key == 9 || (key >= 48 && key <= 57)))
      {
               if(key == 39 || key == 46)
                        return true;
               else
                        return false;
      }
}
 </script>
