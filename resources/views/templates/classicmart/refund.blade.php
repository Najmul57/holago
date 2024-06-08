@extends($template.'layouts.master')
@section('content')
    <!-- refund start -->
    <div class="refund-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="refund-content">
                        <p>We value the trust customers have on us. Therefore, we have a very fast and simple return
                            and refunds policy. Once you put your trust in us you can be rest assured you will get
                            the service you have paid for. Our products go through rigorous quality checks, but in
                            the unlikely event where you have to return and receive a replacement/ refund we will
                            follow these policies below.</p>

                        <p>We encourage our customers to check the item as soon as it is delivered. Please contact
                            us within the applicable return window <strong> (3 days from the received delivery date)
                                .</strong> Your product may be eligible for replacement or return depending on the
                            <strong>condition</strong> of the product.
                        </p>

                        <ul class="single-refund">
                            <strong>VALID CONDITIONS AND REASONS TO RETURN AN ITEM (General):</strong>
                            <li>Delivered product is damaged on arrival (at the time of delivery)</li>
                            <li>Delivered product is defective or Faulty</li>
                            <li>Delivered products has missing parts</li>
                            <li>Delivered product is wrong (not the same as displayed on website or on Order
                                Confirmation)</li>
                            <li>Delivered product is of wrong size. (Delivery charge needs to be paid again)</li>
                        </ul>

                        <ul class="single-refund">
                            <strong>REQUIREMENT FOR A VALID RETURN`AND REPLACE:</strong>
                            <li>Proof of purchase (Confirmation Email, order number, invoice, etc.)</li>
                            <li>Reason for return has to be valid as mentioned above with proof </li>
                        </ul>

                        <ul class="single-refund">
                            <strong>REQUIREMENT FOR A VALID RETURN`AND REFUND:</strong>
                            <li>Refund on returned product is only available <strong class="p-0 d-inline-block">due
                                    to product
                                    unavailability</strong> of the same product that was initially ordered by the
                                customer.</li>
                            <li>Proof of purchase (Confirmation Email, order number, invoice, etc.)</li>
                            <li>Reason for return has to be valid as mentioned above with proof .</li>
                        </ul>

                        <strong><i>Please Note: Holago will provide a free replacement, provided that all conditions
                                for Return and Replace are met. </i></strong> <br>
                        <strong><i>Please Note: If the claim for Return and Replace, Return and Refund must be made
                                within 3 days of Delivery. </i></strong> <br>
                        <strong style="color: #707070;display: block;padding: 10px 0;">Eligibility for Return and
                            Replace or Return and Refunds</strong>
                        <p>You are eligible for return and replace/ refund as long as all the requirements for it
                            are met.</p>
                        <p>Requests for a return and replacement/ refund must be made <strong>within 3 days of the
                                received delivery date.</strong> (E.g. if you receive your product on the 7th Day of
                            the month, the request has to be made by the end of 10th Day of the month).</p>
                        <strong><i>Please Note: Holago will provide a free replacement at no extra charges, provided
                                the exact item is available and only in the case if the product is damaged. If the
                                same item is not available, a refund will be issued to your preferred account in 7
                                days.</i></strong> <br>
                        <strong style="color: #707070;display: block;padding: 15px 0;">RETURN & REPLACEMENT MAY NOT
                            APPLY IN THESE CONDITIONS:</strong>
                        <p>When Holago receives a returned item, it will go through a check to
                            <strong>verify</strong> that none of the conditions mentioned below apply. <strong>A
                                refund will be issued</strong> as soon as Holago has verified the returned item.
                            Please find the conditions below:
                        </p>

                        <ul class="single-refund">
                            <li>Damages due to misuse of the product</li>
                            <li>Incidental damage due to malfunctioning of product</li>
                            <li>Products with tampered or missing serial / UPC numbers</li>
                            <li>Any damage/defect which is not covered under the manufacturer’s warranty</li>
                            <li>Any product that is returned without all original packaging and accessories,
                                including the box, manufacturer’s packaging if any, and all other items originally
                                included with the product(s) delivered.</li>
                        </ul>

                        <strong style="color: #707070; padding: 15px 0;display: block;">Claiming Refunds</strong>

                        <p>If your product is eligible for a refund, you can choose your preferred refund method
                            based on the table below. The <strong>shipping fee is refunded</strong> along with the
                            amount paid for
                            your returned product.</p>
                        <p>The time required to complete a refund depends on the refund method you have selected.
                            Once we have validated and verified the product being returned, the expected refund
                            processing times are as follows:</p>



                        <table class="table table-striped table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th scope="col">Payment Method</th>
                                <th scope="col">Refund Option</th>
                                <th scope="col">Refund Time</th>
                            </tr>
                            </thead>
                            <tbody class="refund-table">
                            <tr>
                                <td>All</td>
                                <td>
                                    <ul>
                                        <li>Holago Gift Voucher</li>
                                        <li>Holago Voucher Discount Code</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <li>Within 24 hours you will have Holago store credit (Insured Products)
                                        </li>
                                        <li>Within 24 hours you will receive a Discount Code.</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Debit or Credit Card</td>
                                <td>
                                    <ul>
                                        <li>Debit or Credit Card</li>
                                        <li>Payment Reversal</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <li> 9-10 working days</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>bKash</td>
                                <td>
                                    <ul>
                                        <li>Bank Deposit / Mobile Payment</li>
                                        <li> Payment Reversal</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <li>7 working days</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>Cash on Delivery (COD)</td>
                                <td>
                                    <ul>
                                        <li>Bank Deposit</li>
                                        <li>Mobile Payment</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <li>7 working days</li>
                                    </ul>
                                </td>
                            </tr>
                            </tbody>
                        </table>



                        <strong><i>Please Note: Holago Voucher Discount Code can only be applied once. The leftover
                                amount will not be refunded or used for the next purchase even if the value of order
                                is smaller than that of voucher value.</i></strong>

                        <h2>Warranty Policy</h2>
                        <h3>How do I know if my product has a warranty?</h3>

                        <p>If a warranty is offered on a product, the <strong>warranty period will be displayed in
                                the ‘Description’ section on the product page.</strong> You can find it at the
                            bottom of the product description in <strong>bold.</strong></p>

                        <h4>Types of Warranties:</h4>
                        <p><strong>Brand Warranty:</strong> This limited warranty will apply to all products that
                            have the <strong>manufacturer’s warranty.</strong> For product defects under normal use
                            circumstances and at the discretion of the company, Brand will provide free of charge
                            repair and/or replacement services within the warranty period. </p>


                        <ul class="single-refund">
                            <li><strong>How do I claim my warranty?</strong></li>
                            <li>If it has been less than <strong style="display: inline-block; padding: 0;">7 days
                                    since delivery:</strong></li>
                        </ul>

                        <p>You may be able to return your product without using a warranty. Contact our customer
                            services to lodge a return request. See our Return and Refunds policy for detailed
                            information. (link to R and R policy here)</p>

                        <ul class="single-refund">
                            <li>If it has been more than<strong style="display: inline-block; padding: 0;"> 7 days
                                    since delivery and the product has a
                                    warranty:</strong></li>
                        </ul>

                        <p>Unfortunately, Holago will be unable to help you further with the delivered item.
                            Customer has to take responsibility to repair the item.</p>

                        <strong><i>Please Note: Violations against warranty, including but not limited to customer
                                induced damage, such as self-repairs, broken display, bending, scratch, dent, burn,
                                soaked or liquid damage, root or manual update, failure to comply with product
                                manual, and so on.</i></strong> <br> <br>

                        <strong style="color: #707070;">Cancellation Policy & Refund Due to Product
                            Unavailability</strong>

                        <ul class="single-refund">
                            <li>Holago understands its customers and we know that mistakes can happen while placing
                                an order. That is why Holago is giving its customers a <strong
                                    style="display: inline-block; padding: 0;">cancellation
                                    period</strong> in which any customer can cancel their order until confirmed by
                                our customer service team. There are no cancellation charges, if the customer has
                                already made an advance payment against the order, the customer will <strong
                                    style="display: inline-block; padding: 0;">receive
                                    a full refund of the advance payment within 24 hours.</strong></li>

                            <li>Holago also expects its customers to understand that in some unlikely situations we
                                are not able to deliver the ordered product due to <strong
                                    style="display: inline-block;padding: 0;">product unavailability or
                                    unforeseen circumstances.</strong> In this event, we will proactively notify the
                                customer beforehand and <strong
                                    style="display: inline-block;padding: 0;">communicate</strong> with the
                                customers until the
                                customer has received their replacement or full refund. </li>

                            <li>Holago takes delivery time promises very seriously. So, if we have a change in
                                delivery time, we will <strong style="display: inline-block;padding: 0;">proactively
                                    notify you in advance.</strong> Customers
                                will have the <strong style="display: inline-block;padding: 0;">option to
                                    cancel</strong> the delivery and the full amount
                                will be refunded to the customer’s preferred account <strong
                                    style="display: inline-block;padding: 0;">within 24
                                    hours.</strong></li>

                            <li>Advance payment is required for the delivery in some locations and <products
                                    class="stro"> We may cancel any order if the advance payment is not made by the
                                    customer for such orders.</products>
                            </li>

                            <li>Please bear in mind that Holago reserves the right to cancel orders at any given
                                time due to circumstances beyond our control.</li>
                        </ul>

                        <h4><strong><i>Please Note: Orders can be cancelled until it is confirmed by the
                                    confirmation call. Once the item is processed, we are unable to cancel the order
                                    as it is already out for delivery.</i></strong></h4>
                        
                        <h4><strong><i>You can exchange your product by providing exchange charges as following:
 Inside Exchange Charge - 100 taka
                            Outside Dhaka Exchange Charge  - 150 taka</i></strong></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- refund end -->
@endsection