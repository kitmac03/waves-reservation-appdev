
<link rel="stylesheet" href="../css/cus_bal.css">

@section('reservation-content')           
<div class="profile-content">
   <div class="balance-container">
         <div class="balance-card">
            <div class="balance-header">
               <h2>Payment Details</h2>
            </div>
            
            <div class="balance-content">
               <div class="reservation-details">
                     <div class="detail-group">
                        <span class="detail-label">Reserved By:</span>
                        <span class="detail-value">Manny Pacquiao</span>
                     </div>
                     
                     <div class="detail-group">
                        <span class="detail-label">Reservation Date:</span>
                        <span class="detail-value">June 15, 2023</span>
                     </div>
                     
                     <div class="detail-group">
                        <span class="detail-label">Date:</span>
                        <span class="detail-value">June 30, 2023</span>
                     </div>
                     
                     <div class="detail-group">
                        <span class="detail-label">Reservation ID:</span>
                        <span class="detail-value">RES-2023-0065</span>
                     </div>
                     
                     <div class="detail-group">
                        <span class="detail-label">Amenity:</span>
                        <span class="detail-value">Cottage 2</span>
                     </div>
               </div>
               
               <div class="payment-summary">
                     <div class="payment-row">
                        <span>Total Amount:</span>
                        <span>₱15,000.00</span>
                     </div>
                     <div class="payment-row">
                        <span>Downpayment Paid:</span>
                        <span>₱5,000.00</span>
                     </div>
                     <div class="payment-row">
                        <span>Remaining Balance:</span>
                        <span>₱10,000.00</span>
                     </div>
               </div>
               
               <div class="payment-methods">
                     <h3>Select Payment Method</h3>
                     
                     <div class="payment-option selected" onclick="selectPayment(this, 'gcash')">
                        <div class="payment-icon">
                           <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="payment-info">
                           <div class="payment-name">GCash</div>
                           <div class="payment-desc">Pay using your GCash wallet</div>
                        </div>
                        <i class="fas fa-check-circle" style="color: rgba(49, 105, 109, 0.751);"></i>
                     </div>
                     
                     <div class="payment-option" onclick="selectPayment(this, 'cash')">
                        <div class="payment-icon">
                           <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="payment-info">
                           <div class="payment-name">Cash Payment</div>
                           <div class="payment-desc">Pay in cash upon arrival</div>
                        </div>
                        <i class="fas fa-check-circle" style="color: #ddd;"></i>
                     </div>
                     
                     <button class="pay-button" onclick="processPayment()">
                        <i class="fas fa-check"></i> Pay Now
                     </button>
               </div>
            </div>
         </div>
   </div>
</div>

