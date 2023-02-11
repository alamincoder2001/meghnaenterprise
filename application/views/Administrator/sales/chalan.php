<div id="chalan">
    <div class="row" style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-xs-12">
                    <a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>

            <div id="invoiceContent">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <div _h098asdh style="font-size:25px">
                            Chalan
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <strong>Customer Id:</strong> {{ sales.Customer_Code }}<br>
                        <strong>Customer Name:</strong> {{ sales.Customer_Name }}<br>
                        <strong>Customer Address:</strong> {{ sales.Customer_Address }}<br>
                        <strong>Customer Mobile:</strong> {{ sales.Customer_Mobile }}
                    </div>
                    <div class="col-xs-4 text-right">
                        <strong>Sales by:</strong> {{ sales.AddBy }}<br>
                        <strong>Invoice No.:</strong> {{ sales.SaleMaster_InvoiceNo }}<br>
                        <strong>Sales Date:</strong> {{ sales.SaleMaster_SaleDate }} {{ formatDateTime(sales.AddTime, 'h:mm a') }}<br>
                        <strong>Delivery Address.:</strong> {{ sales.delivery_address }}<br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div _d9283dsc></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <table _a584de>
                            <thead>
                                <tr>
                                    <td>Sl.</td>
                                    <td>Description</td>
                                    <td>Qnty</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, sl) in cart">
                                    <td>{{ sl + 1 }}</td>
                                    <td>{{ product.Product_Name }}</td>
                                    <td>{{ product.SaleDetails_TotalQuantity }} {{ product.Unit_Name }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width:100%;">
                            <tfoot>
                                <tr>
                                    <td colspan="3">
                                        <div style="position: sticky;bottom:0;left:0;width:100%;margin-top:80px;">
                                            <div class="row" style="border-bottom:1px solid #ccc;padding-bottom:6px;margin:0;">
                                                <div class="col-xs-4">
                                                    <span style="text-decoration:overline;">Received by</span><br><br>
                                                </div>
                                                <div class="col-xs-4">
                                                    <span style="text-decoration:overline;">Prepared by</span><br><br>
                                                </div>
                                                <div class="col-xs-4 text-right">
                                                    <span style="text-decoration:overline;">Authorized by</span>
                                                </div>
                                            </div>
                                            <p style="margin-top:5px;font-weight:700;">Dealer : </p>
                                            <div style="width:100%;display:flex;gap:10px;">
                                                <div style="width: 20%;border:1px dashed #dbd8d8;">
                                                    <img src="/uploads/1.png" style="width:100%;height:100px;">
                                                    <p style="text-align:center;padding-top:10px;margin:0;font-weight:700;">Npoly</p>
                                                </div>
                                                <div style="width: 20%;border:1px dashed #dbd8d8;">
                                                    <img src="/uploads/2.png" style="width:100%;height:100px">
                                                    <p style="text-align:center;padding-top:10px;margin:0;font-weight:700;">Hatim Group</p>
                                                </div>
                                                <div style="width: 20%;border:1px dashed #dbd8d8;">
                                                    <img src="/uploads/4.jpg" style="width:100%;height:100px">
                                                    <p style="text-align:center;padding-top:10px;margin:0;font-weight:700;">Pedrollo</p>
                                                </div>
                                                <div style="width:20%;border:1px dashed #dbd8d8;">
                                                    <img src="/uploads/5.png" style="width:100%;height:100px">
                                                    <p style="text-align:center;padding-top:10px;margin:0;font-weight:700;">Stella</p>
                                                </div>
                                                <div style="width:20%;border:1px dashed #dbd8d8;">
                                                    <img src="/uploads/6.jpg" style="width:100%;height:100px">
                                                    <p style="text-align:center;padding-top:10px;margin:0;font-weight:700;">RAK Ceramic</p>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
    new Vue({
        el: '#chalan',
        data() {
            return {
                sales: {
                    SaleMaster_SlNo: parseInt('<?php echo $saleId; ?>'),
                    SaleMaster_InvoiceNo: null,
                    SalseCustomer_IDNo: null,
                    SaleMaster_SaleDate: null,
                    Customer_Name: null,
                    Customer_Address: null,
                    Customer_Mobile: null,
                    SaleMaster_TotalSaleAmount: null,
                    SaleMaster_TotalDiscountAmount: null,
                    SaleMaster_TaxAmount: null,
                    SaleMaster_Freight: null,
                    SaleMaster_SubTotalAmount: null,
                    SaleMaster_PaidAmount: null,
                    SaleMaster_DueAmount: null,
                    SaleMaster_Previous_Due: null,
                    SaleMaster_Description: null,
                    AddBy: null
                },
                cart: [],
                style: null,
                companyProfile: null,
                currentBranch: null
            }
        },
        created() {
            this.setStyle();
            this.getSales();
            this.getCompanyProfile();
            this.getCurrentBranch();
        },
        methods: {
            getSales() {
                axios.post('/get_sales', {
                    salesId: this.sales.SaleMaster_SlNo
                }).then(res => {
                    this.sales = res.data.sales[0];
                    this.cart = res.data.saleDetails;
                })
            },
            getCompanyProfile() {
                axios.get('/get_company_profile').then(res => {
                    this.companyProfile = res.data;
                })
            },
            getCurrentBranch() {
                axios.get('/get_current_branch').then(res => {
                    this.currentBranch = res.data;
                })
            },
            formatDateTime(datetime, format) {
                return moment(datetime).format(format);
            },
            setStyle() {
                this.style = document.createElement('style');
                this.style.innerHTML = `
                div[_h098asdh]{
                    background-color:#e0e0e0;
                    font-weight: bold;
                    font-size:15px;
                    margin-bottom:15px;
                    padding: 5px;
                }
                div[_d9283dsc]{
                    padding-bottom:25px;
                    border-bottom: 2px solid #222;
                    margin-bottom: 15px;
                }
                table[_a584de]{
                    width: 100%;
                    text-align:center;
                }
                table[_a584de] thead{
                    font-weight:bold;
                }
                table[_a584de] td{
                    padding: 3px;
                    border: 2px solid #222;
                }
                table[_t92sadbc2]{
                    width: 100%;
                }
                table[_t92sadbc2] td{
                    padding: 2px;
                }
            `;
                document.head.appendChild(this.style);
            },
            async print() {
                let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#invoiceContent').innerHTML}
							</div>
						</div>
					</div>
				`;

                var reportWindow = window.open('', 'PRINT', `height=${screen.height}, width=${screen.width}`);
                reportWindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php'); ?>
				`);

                reportWindow.document.body.innerHTML += reportContent;

                if (this.searchType == '' || this.searchType == 'user') {
                    let rows = reportWindow.document.querySelectorAll('.record-table tr');
                    rows.forEach(row => {
                        row.lastChild.remove();
                    })
                }

                let invoiceStyle = reportWindow.document.createElement('style');
                invoiceStyle.innerHTML = this.style.innerHTML;
                reportWindow.document.head.appendChild(invoiceStyle);

                reportWindow.focus();
                await new Promise(resolve => setTimeout(resolve, 2000));
                reportWindow.print();
                reportWindow.close();
            }
        }
    })
</script>