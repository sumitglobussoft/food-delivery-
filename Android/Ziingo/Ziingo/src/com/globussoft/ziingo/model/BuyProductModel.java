package com.globussoft.ziingo.model;

public class BuyProductModel {
	
	public String Food_name = "";
	public String Food_image = "";
	public String Food_desc = "";
	public String Food_price = "";
	public String Food_quantity = "";
	public String Food_subtotal_amt = "";
	public String Food_total_amt = "";
	public String Food_delivery_charge = "";
	
	public String product_bag_id = ""; 
	
	public BuyProductModel() { 
	}

	public BuyProductModel(String Food_name, String Food_image, String Food_desc, 
			String Food_price, String Food_quantity, String Food_total_amt, 
			String Food_subtotal_amt, String Food_delivery_charge, String product_order_id) {
		
		this.Food_name = Food_name;
		this.Food_image = Food_image;
		this.Food_desc = Food_desc;
		this.Food_price = Food_price;
		this.Food_quantity = Food_quantity;
		this.Food_total_amt = Food_total_amt;
		this.Food_subtotal_amt = Food_subtotal_amt;
		this.Food_delivery_charge = Food_delivery_charge;
		this.product_bag_id = product_order_id;
		
		
		
	}
		
		public String getFood_name() {
			return Food_name;
		}

		public void setFood_name(String Food_name) {
			this.Food_name = Food_name;
		}
		
		public String getFood_image() {
			return Food_image;
		}

		public void setFood_image(String Food_image) {
			this.Food_image = Food_image;
		}
		
		public String getFood_desc() {
			return Food_desc;
		}

		public void setFood_desc(String Food_desc) {
			this.Food_desc = Food_desc;
		}
		
		public String getFood_price() {
			return Food_price;
		}

		public void setFood_price(String Food_price) {
			this.Food_price = Food_price;
		}
		
		public String getFood_quantity() {
			return Food_quantity;
		}

		public void setFood_quantity(String Food_quantity) {
			this.Food_quantity = Food_quantity;
		}
		
		public String getFood_total_amt() {
			return Food_total_amt;
		}

		public void setFood_total_amt(String Food_total_amt) {
			this.Food_total_amt = Food_total_amt;
		}
		
		public String getFood_subtotal_amt() {
			return Food_subtotal_amt;
		}

		public void setFood_subtotal_amt(String Food_subtotal_amt) {
			this.Food_subtotal_amt = Food_subtotal_amt;
		}
		
		public String getFood_delivery_charge() {
			return Food_delivery_charge;
		}

		public void setFood_delivery_charge(String Food_delivery_charge) {
			this.Food_delivery_charge = Food_delivery_charge;
		}
		
		public String getproduct_bag_id() {
			return product_bag_id;
		}

		public void setproduct_bag_id(String product_bag_id) {
			this.product_bag_id = product_bag_id;
		}
		
		@Override
		public String toString() {
			return "ProductListModel [Food_name = " + Food_name + 
					", Food_image = " + Food_image +
					", Food_desc = " + Food_desc +
					", Food_price = " + Food_price + 
					", Food_quantity = " + Food_quantity + 
					", Food_total_amt = " + Food_total_amt +
					", Food_subtotal_amt = " + Food_subtotal_amt +
					", Food_delivery_charge = " + Food_delivery_charge +
					", product_bag_id = " + product_bag_id +
					"]";
		}
			
		
	}
	
	


