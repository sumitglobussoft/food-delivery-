package com.globussoft.ziingo.model;


public class ProductListModel {
	
	public String Product_id = "";
	public String Agent_Id = "";
	public String Hotel_Id = "";
	public String Item_type = "";
	public String Category_id = "";
	public String Product_name = "";
	public String Product_desc = "";
	public String Product_image = "";
	public String Product_status = "";
	public String Cost = "";
	public String Delivery_time = "";
	public String Added_date = "";
	public String Service_tax = "";
	
	public ProductListModel() { 
	}

	public ProductListModel(String Product_id, String Agent_Id, String Hotel_Id, 
			String Item_type, String Category_id, String Product_name,
			String Product_desc, String Product_image, String Product_status, String Cost,
			String Delivery_time, String Added_date, String Service_tax) {
		
		this.Product_id = Product_id;
		this.Agent_Id = Agent_Id;
		this.Hotel_Id = Hotel_Id;
		this.Item_type = Item_type;
		this.Category_id = Category_id;
		this.Product_name = Product_name;		
		this.Product_desc = Product_desc;
		this.Product_image = Product_image;			
		this.Product_status = Product_status;		
		this.Cost = Cost;
		this.Delivery_time = Delivery_time;
		this.Added_date = Added_date;
		this.Service_tax = Service_tax;
			
		
	}
	
	public String getProduct_id() {
		return Product_id;
	}

	public void setProduct_id(String product_id) {
		this.Product_id = product_id;
	}
	
	public String getAgent_Id() {
		return Agent_Id;
	}

	public void setAgent_Id(String agent_id) {
		this.Agent_Id = agent_id;
	}
	
	public String getHotel_Id() {
		return Hotel_Id;
	}

	public void setHotel_Id(String hotel_id) {
		this.Hotel_Id = hotel_id;
	}
	
	public String getItem_type() {
		return Item_type;
	}

	public void setItem_type(String item_type) {
		this.Item_type = item_type;
	}
	
	public String getCategory_id() {
		return Category_id;
	}

	public void setCategory_id(String category_id) {
		this.Category_id = category_id;
	}
	
	public String getProduct_name() {
		return Product_name;
	}

	public void setProduct_name(String product_name) {
		this.Product_name = product_name;
	}
	
	public String getProduct_desc() {
		return Product_desc;
	}

	public void setProduct_desc(String product_desc) {
		this.Product_desc = product_desc;
	}
	
	public String getProduct_image() {
		return Product_image;
	}

	public void setProduct_image(String product_image) {
		this.Product_image = product_image;
	}
		

	public String getProduct_status() {
		return Product_status;
	}

	public void setProduct_status(String product_status) {
		this.Product_status = product_status;
	}

	public String getCost() {
		return Cost;
	}

	public void setCost(String cost) {
		this.Cost = cost;
	}
	
	public String getDelivery_time() {
		return Delivery_time;
	}

	public void setDelivery_time(String delivery_time) {
		this.Delivery_time = delivery_time;
	}
	
	public String getAdded_date() {
		return Added_date;
	}

	public void setAdded_date(String added_date) {
		this.Added_date = added_date;
	}
	
	public String getService_tax() {
		return Service_tax;
	}

	public void setService_tax(String Service_tax) {
		this.Service_tax = Service_tax;
	}
	
	
	@Override
	public String toString() {
		return "ProductListModel [Product_id = " + Product_id + 
				", Agent_Id = " + Agent_Id +
				", Hotel_Id = " + Hotel_Id +
				", Item_type = " + Item_type + 
				", Category_id = "	+ Category_id + 
				", Product_name = "	+ Product_name +
				", Product_desc = "	+ Product_desc +
				", Product_image = "	+ Product_image +
				", Product_status = "	+ Product_status +
				", Cost = "	+ Cost +
				", Delivery_time = "	+ Delivery_time +
				", Added_date = "  + Added_date +
				", Service_tax = "  + Service_tax +

				"]";
	}


}
