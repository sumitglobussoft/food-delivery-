package com.globussoft.ziingo.model;

public class BagModel {

	public String Bag_product_image = "";	
	public String Bag_product_name = "";
	public String Bag_product_price = "";
	public String Bag_product_qnt = "";
	//public String Bag_total_amount = "";
	public String product_stockQuantity = "";
	public String product_orderedQuantity = "";
    
	public String order_id = "";
	public String product_id = "";
	public String hotel_id = "";
	
	public String Bag_product_cartid ="";
	
	public BagModel() {
	}

	public BagModel(String Bag_product_name, String Bag_product_price,
			String Bag_product_qnt, String order_id, String product_id,
			String hotel_id, String Bag_product_image, 
			String Bag_product_cartid, String product_stockQuantity, String product_orderedQuantity) {

		this.Bag_product_name = Bag_product_name;
		this.Bag_product_price = Bag_product_price;
		this.Bag_product_qnt = Bag_product_qnt;
		this.Bag_product_image = Bag_product_image;
		this.order_id = order_id;
		this.product_id = product_id;
		this.hotel_id = hotel_id;		
		this.Bag_product_cartid = Bag_product_cartid;
		this.product_stockQuantity = product_stockQuantity;
		this.product_orderedQuantity = product_orderedQuantity;
		//this.Bag_total_amount = Bag_total_amount;

	}
	
	public BagModel(String product_id, String Bag_product_name, String Bag_product_qnt, 
			String Bag_product_price, String Bag_product_image, String Bag_product_cartid) {

		this.Bag_product_name = Bag_product_name;
		this.Bag_product_price = Bag_product_price;
		this.Bag_product_qnt = Bag_product_qnt;
		this.Bag_product_image = Bag_product_image;		
		this.product_id = product_id;
		this.Bag_product_cartid = Bag_product_cartid;

	}
	
	public String getproduct_orderedQuantity() {
		return product_orderedQuantity;
	}

	public void setproduct_orderedQuantity(String product_orderedQuantity) {
		this.product_orderedQuantity = product_orderedQuantity;
	}
	
	public String getproduct_stockQuantity() {
		return product_stockQuantity;
	}

	public void setproduct_stockQuantity(String product_stockQuantity) {
		this.product_stockQuantity = product_stockQuantity;
	}
	
	public String getBag_product_cartid() {
		return Bag_product_cartid;
	}

	public void setBag_product_cartid(String Bag_product_cartid) {
		this.Bag_product_cartid = Bag_product_cartid;
	}

	public String getBag_product_name() {
		return Bag_product_name;
	}

	public void setBag_product_name(String Bag_product_name) {
		this.Bag_product_name = Bag_product_name;
	}

	public String getBag_product_price() {
		return Bag_product_price;
	}

	public void setBag_product_price(String Bag_product_price) {
		this.Bag_product_price = Bag_product_price;
	}

	public String getBag_product_qnt() {
		return Bag_product_qnt;
	}

	public void setBag_product_qnt(String Bag_product_qnt) {
		this.Bag_product_qnt = Bag_product_qnt;
	}

	public String getorder_id() {
		return order_id;
	}

	public void setorder_id(String order_id) {
		this.order_id = order_id;
	}

	public String getproduct_id() {
		return product_id;
	}

	public void setproduct_id(String product_id) {
		this.product_id = product_id;
	}

	public String gethotel_id() {
		return hotel_id;
	}

	public void sethotel_id(String hotel_id) {
		this.hotel_id = hotel_id;
	}
	
	public String getBag_product_image() {
		return Bag_product_image;
	}

	public void setBag_product_image(String Bag_product_image) {
		this.Bag_product_image = Bag_product_image;
	}	
	
	
	/*public String getBag_total_amount() {
		return Bag_total_amount;
	}

	public void setBag_total_amount(String Bag_total_amount) {
		this.Bag_total_amount = Bag_total_amount;
	}*/

	@Override
	public String toString() {
		return "BagModel [Bag_product_name = " + Bag_product_name
				+ ", Bag_product_price = " + Bag_product_price
				+ ", Bag_product_qnt = " + Bag_product_qnt 
				+ ", order_id = " + order_id 
				+ ", product_id = " + product_id 
				+ ", hotel_id = " + hotel_id 
				+ ", Bag_product_image = " + Bag_product_image  			
				+ ", Bag_product_cartid = " + Bag_product_cartid 
				+ ", product_stockQuantity = " + product_stockQuantity 
				+ ", product_orderedQuantity = " + product_orderedQuantity 
				+ "]";
	}

}
