<template>
  <div class="container py-5 payment-container">
    <div class="row mb-4">
      <div class="col-lg-8 mx-auto text-center">
        <h1 class="display-6"><b>Payment</b></h1>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 mx-auto">
        <div class="card shadow-sm border-0">
          <div class="card-header text-white">
            <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
              <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                <li class="nav-item">
                  <a
                    @click="selectTab('credit-card')"
                    :class="['nav-link', { active: selectedTab === 'credit-card' }]"
                  >
                    <i class="fas fa-credit-card mr-2"></i> Credit Card
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    @click="selectTab('paypal')"
                    :class="['nav-link', { active: selectedTab === 'paypal' }]"
                  >
                    <i class="fab fa-paypal mr-2"></i> Paypal
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    @click="selectTab('net-banking')"
                    :class="['nav-link', { active: selectedTab === 'net-banking' }]"
                  >
                    <i class="fas fa-mobile-alt mr-2"></i> Net Banking
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div v-show="selectedTab === 'credit-card'" class="pt-3">
                <form @submit.prevent="handlePayment">
                  <div class="form-group">
                    <label for="username">
                      <h6>Card Owner</h6>
                    </label>
                    <input
                      v-model="form.username"
                      type="text"
                      name="username"
                      placeholder="Card Owner Name"
                      required
                      class="form-control"
                    />
                  </div>
                  <div class="form-group">
                    <label for="cardNumber">
                      <h6>Card number</h6>
                    </label>
                    <div class="input-group">
                      <input
                        v-model="form.cardNumber"
                        type="text"
                        name="cardNumber"
                        placeholder="Valid card number"
                        class="form-control"
                        required
                      />
                      <div class="input-group-append">
                        <span class="input-group-text text-muted">
                          <i class="fab fa-cc-visa mx-1"></i>
                          <i class="fab fa-cc-mastercard mx-1"></i>
                          <i class="fab fa-cc-amex mx-1"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-8">
                      <div class="form-group">
                        <label>
                          <h6>Expiration Date</h6>
                        </label>
                        <div class="input-group">
                          <input
                            v-model="form.expMonth"
                            type="number"
                            placeholder="MM"
                            name="expMonth"
                            class="form-control"
                            required
                          />
                          <input
                            v-model="form.expYear"
                            type="number"
                            placeholder="YY"
                            name="expYear"
                            class="form-control"
                            required
                          />
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group mb-4">
                        <label
                          data-toggle="tooltip"
                          title="Three digit CV code on the back of your card"
                        >
                          <h6>CVV <i class="fa fa-question-circle d-inline"></i></h6>
                        </label>
                        <input v-model="form.cvv" type="text" required class="form-control" />
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="subscribe btn btn-warning btn-block shadow-sm">
                      Confirm Payment
                    </button>
                  </div>
                </form>
              </div>
              <div v-show="selectedTab === 'paypal'" class="pt-3">
                <h6 class="pb-2">Select your paypal account type</h6>
                <div class="form-group">
                  <label class="radio-inline">
                    <input
                      v-model="form.paypalType"
                      type="radio"
                      name="optradio"
                      value="Domestic"
                      checked
                    />
                    Domestic
                  </label>
                  <label class="radio-inline">
                    <input
                      v-model="form.paypalType"
                      type="radio"
                      name="optradio"
                      value="International"
                      class="ml-5"
                    />International
                  </label>
                </div>
                <p>
                  <button type="button" class="btn btn-primary">
                    <i class="fab fa-paypal mr-2"></i> Log into my Paypal
                  </button>
                </p>
                <p class="text-muted">
                  Note: After clicking on the button, you will be directed to a secure gateway for
                  payment. After completing the payment process, you will be redirected back to the
                  website to view details of your order.
                </p>
              </div>
              <div v-show="selectedTab === 'net-banking'" class="pt-3">
                <div class="form-group">
                  <label for="Select Your Bank">
                    <h6>Select your Bank</h6>
                  </label>
                  <select v-model="form.bank" class="form-control" id="ccmonth">
                    <option value="" selected disabled>--Please select your Bank--</option>
                    <option>Bank 1</option>
                    <option>Bank 2</option>
                    <option>Bank 3</option>
                    <option>Bank 4</option>
                    <option>Bank 5</option>
                    <option>Bank 6</option>
                    <option>Bank 7</option>
                    <option>Bank 8</option>
                    <option>Bank 9</option>
                    <option>Bank 10</option>
                  </select>
                </div>
                <div class="form-group">
                  <p>
                    <button type="button" class="btn btn-primary">
                      <i class="fas fa-mobile-alt mr-2"></i> Proceed Payment
                    </button>
                  </p>
                </div>
                <p class="text-muted">
                  Note: After clicking on the button, you will be directed to a secure gateway for
                  payment. After completing the payment process, you will be redirected back to the
                  website to view details of your order.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { Tooltip } from 'bootstrap';

export default {
  data() {
    return {
      selectedTab: 'credit-card',
      form: {
        username: '',
        cardNumber: '',
        expMonth: '',
        expYear: '',
        cvv: '',
        paypalType: 'Domestic',
        bank: ''
      }
    }
  },
  methods: {
    selectTab(tab) {
      this.selectedTab = tab;
    },
    async handlePayment() {
      try {
        const response = await axios.post('/process-payment', this.form);
        console.log('Payment processed successfully:', response.data);
      } catch (error) {
        console.error('Payment processing failed:', error.response.data);
      }
    },
    enableTooltips() {
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new Tooltip(tooltipTriggerEl)
      })
    }
  },
  mounted() {
    this.enableTooltips()
  }
}
</script>

<style scoped>
.payment-container {
  background-image: url('/path/to/your/background-image.jpg');
  background-size: cover;
  padding-top: 5rem;
  padding-bottom: 5rem;
}

.rounded {
  border-radius: 1rem;
}

.nav-pills .nav-link {
  color: #555;
}

.nav-pills .nav-link.active {
  color: white;
  background-color: #f39c12; /* A shade of orange */
}

.card {
  border: none;
}

.card-header {
  border-bottom: none;
  background-color: #f39c12; /* A shade of orange */
  color: white;
}

.input-group-text {
  background-color: #f8f9fa;
}

.btn-primary {
  background-color: #f39c12; /* A shade of orange */
  border-color: #f39c12;
}
.btn-primary:hover {
  background-color: #e67e22; /* A darker shade of orange */
  border-color: #e67e22;
}
.form-control:focus {
  box-shadow: none;
  border-color: orange;
}
.subscribe {
  padding: 10px;
  font-size: 18px;
}
</style>
