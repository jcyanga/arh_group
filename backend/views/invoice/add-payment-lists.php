<div style="margin-left: 10px;" class="row">

                <div class="col-md-5">
                    <span class="pmLabel" ><i class="fa fa-bank"></i> MODE OF PAYMENT </span>   

                    <select  name="Payment[mPayment_type]" class="form_pm form-control" id="mPayment_type" >
                        <option value="">CHOOSE PAYMENT HERE.</option>
                        <option value="Cash_Payment">Cash Payment</option>
                        <option value="Telegraphic_Transfer">Telegraphic Transfer</option>
                        <option value="Money_Orders">Money Orders</option>
                        <option value="Bill_of_Exchange">Bill of Exchange</option>
                        <option value="Promissory_Notes">Promissory Notes</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Bank_Draft">Bank Draft</option>
                    </select>
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-5">
                    <span class="pmLabel" ><i class="fa fa-money"></i> AMOUNT </span>

                    <input type="text" name="Payment[mAmount]" class="form_pm form-control" id="mAmount" placeholder="Enter Amount here." />
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-5">
                    <span class="pmLabel" ><i class="fa fa-dollar"></i> DISCOUNT </span>

                    <input type="text" name="Payment[mDiscount]" class="form_pm form-control" id="mDiscount" placeholder="Enter Discount here." />
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-5">
                    <input type="checkbox" class="chkboxRedeemPoints" id="chkboxRedeemPoints" > <b>Redeem Points?</b>
                    <br/>
                    
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-5">
                    <span class="pmLabel" ><i class="fa fa-dot-circle-o"></i> POINTS EARNED </span>

                    <input type="text" name="Payment[mPoints_earned]" class="form_pm form-control" id="mPoints_earned" placeholder="Enter Points Earned here." />
                </div>

            </div>
            <br/>

            <div style="margin-left: 10px;" class="row">

                <div class="col-md-11">
                    <span class="pmLabel" ><i class="fa fa-comments"></i> REMARKS </span>

                    <textarea cols="20" rows="3" name="Payment[mRemarks]" class="form_pmTxtArea form-control" id="mRemarks" placeholder="Write Remarks here."></textarea>
                </div>

            </div>
            <br/>