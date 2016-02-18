package com.globussoft.ziingo.model;


public class MenuListModel {
	
	public String Id = "";	
	public String Category_Id = "";
	public String Category_Name = "";
	public String Category_Type = "";
	public String Category_Status = "";
	public String Category_Desc = "";
	public String Last_Update = "";
	
	public String Cuisine_Id = "";
	public String Cuisine_Name = "";
	public String Cuisine_Status = "";
	
	public MenuListModel() {
	}

	public MenuListModel(String Id, String Category_Id , String Category_Name, String Category_Status,
			             String Category_Desc, String Last_Update, String Cuisine_Id, String Cuisine_Name, 
			             String Cuisine_Status) {
		
		this.Id = Id;
		this.Category_Id = Category_Id;
		this.Category_Name = Category_Name;	
		this.Category_Status = Category_Status;
		this.Category_Desc = Category_Desc;
		this.Last_Update = Last_Update;
		this.Cuisine_Id = Cuisine_Id;
		this.Cuisine_Name = Cuisine_Name;
		this.Cuisine_Status = Cuisine_Status;
		
	}
	
	public String getId() {
		return Id;
	}

	public void setId(String Id) {
		this.Id = Id;
	}
	
	public String getCategory_Id() {
		return Category_Id;
	}

	public void setCategory_Id(String Category_Id) {
		this.Category_Id = Category_Id;
	}
	
	public String getCategory_Name() {
		return Category_Name;
	}

	public void setCategory_Name(String Category_Name) {
		this.Category_Name = Category_Name;
	}
	
	
	public String getCategory_Desc() {
		return Category_Desc;
	}

	public void setCategory_Desc(String Category_Desc) {
		this.Category_Desc = Category_Desc;
	}
	
		
	public String getCategory_Status() {
		return Category_Status;
	}

	public void setCategory_Status(String Category_Status) {
		this.Category_Status = Category_Status;
	}
	
	public String getLast_Update() {
		return Last_Update;
	}

	public void setLast_Update(String Last_Update) {
		this.Last_Update = Last_Update;
	}
	
	public String getCuisine_Id() {
		return Cuisine_Id;
	}

	public void setCuisine_Id(String Cuisine_Id) {
		this.Cuisine_Id = Cuisine_Id;
	}
	
	public String getCuisine_Name() {
		return Cuisine_Name;
	}

	public void setCuisine_Name(String Cuisine_Name) {
		this.Cuisine_Name = Cuisine_Name;
	}
	public String getCuisine_Status() {
		return Cuisine_Status;
	}

	public void setCuisine_Status(String Cuisine_Status) {
		this.Cuisine_Status = Cuisine_Status;
	}
	
	
	
	@Override
	public String toString() {
		return "MenuListModel [Id = " + Id +
				",Category_Id = " + Category_Id + 
				", Category_Name = " + Category_Name +
				", Category_Status = " + Category_Status +
				", Category_Desc = " + Category_Desc +
				", Last_Update = " + Last_Update +
				", Cuisine_Id = " + Cuisine_Id +
				", Cuisine_Name = " + Cuisine_Name +
				", Cuisine_Status = " + Cuisine_Status +				
				"]";
	
	}
	

}
