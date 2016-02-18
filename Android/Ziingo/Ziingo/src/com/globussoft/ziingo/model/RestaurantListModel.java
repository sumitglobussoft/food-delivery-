package com.globussoft.ziingo.model;

import java.util.ArrayList;

public class RestaurantListModel {

	public boolean isChecekd;
	public boolean isChecekd() {
		return isChecekd;
	}

	public void setChecekd(boolean isChecekd) {
		this.isChecekd = isChecekd;
	}

	public String getReviews_count() {
		return Reviews_count;
	}

	public void setReviews_count(String reviews_count) {
		Reviews_count = reviews_count;
	}

	public String Id = "";
	public String Agent_Id = "";
	public String Agent_Fullname = "";
	public String Agent_Lastname = "";
	public String City = "";
	public String State = "";
	public String Country = "";
	public String Hotel_loc = "";
	public String Hotel_loc_id = "";
	public String Hotel_loc_status = "";
	public String Hotel_loc_type = "";

	public String Rest_name = "";
	public String Rest_add = "";
	public String Primary_phone = "";
	public String Secondary_phone = "";
	public String Open_time = "";
	public String Closing_time = "";
	public String Hotel_status = "";
	public String Notice = "";
	public String ThumbnailUrl = "";
	public String Delivery_charge = "";
	public String Reviews_count = "";

	public String Email = "";
	public String Login = "";
	public String Password = "";
	public String Reg_date = "";
	public String Agent_status = "";
	public String Membership = "";
	public String Min_order = "";

	public String Cuisine;

	public RestaurantListModel() {
	}

	public RestaurantListModel(String Id, String Agent_Id,
			String Agent_Fullname, String Agent_Lastname, String City,
			String State, String Country, String Rest_name, String Rest_add,
			String Primary_phone, String Secondary_phone, String Open_time,
			String Closing_time, String Hotel_status, String Notice,
			String ThumbnailUrl, String Reviews_count, String Cuisine,
			String Email, String Login, String Password, String Reg_date,
			String Agent_status, String Membership, String Min_order,
			String Delivery_charge, String Hotel_loc, String Hotel_loc_id, String Hotel_loc_status, String Hotel_loc_type) {

		this.Id = Id;
		this.Agent_Id = Agent_Id;
		this.Agent_Fullname = Agent_Fullname;
		this.Agent_Lastname = Agent_Lastname;
		this.City = City;
		this.State = State;
		this.Country = Country;
		this.Rest_name = Rest_name;
		this.Rest_add = Rest_add;
		this.Primary_phone = Primary_phone;
		this.Secondary_phone = Secondary_phone;
		this.Open_time = Open_time;
		this.Closing_time = Closing_time;
		this.Hotel_status = Hotel_status;
		this.Notice = Notice;
		this.ThumbnailUrl = ThumbnailUrl;
		this.Reviews_count = Reviews_count;
        this.Delivery_charge = Delivery_charge;
		this.Cuisine = Cuisine;
		this.Email = Email;
		this.Login = Login;
		this.Password = Password;
		this.Reg_date = Reg_date;
		this.Agent_status = Agent_status;
		this.Membership = Membership;
		this.Min_order = Min_order;
		this.Hotel_loc = Hotel_loc;
		this.Hotel_loc_id = Hotel_loc_id;
		this.Hotel_loc_status = Hotel_loc_status;
		this.Hotel_loc_type = Hotel_loc_type;

	}

	public String getId() {
		return Id;
	}

	public void setId(String id) {
		this.Id = id;
	}

	public String getAgent_Id() {
		return Agent_Id;
	}

	public void setAgent_Id(String agent_id) {
		this.Agent_Id = agent_id;
	}

	public String getAgent_Fullname() {
		return Agent_Fullname;
	}

	public void setAgent_Fullname(String agent_fullname) {
		this.Agent_Fullname = agent_fullname;
	}

	public String getAgent_Lastname() {
		return Agent_Lastname;
	}

	public void setAgent_Lastname(String agent_lastname) {
		this.Agent_Lastname = agent_lastname;
	}

	public String getState() {
		return State;
	}

	public void setState(String State) {
		this.State = State;
	}

	public String getCity() {
		return City;
	}

	public void setCity(String city) {
		this.City = city;
	}

	public String getCountry() {
		return Country;
	}

	public void setCountry(String country) {
		this.Country = country;
	}

	public String getRest_name() {
		return Rest_name;
	}

	public void setRest_name(String rest_name) {
		this.Rest_name = rest_name;
	}

	public String getRest_add() {
		return Rest_add;
	}

	public void setRest_add(String rest_add) {
		this.Rest_add = rest_add;
	}

	public String getPrimary_phone() {
		return Primary_phone;
	}

	public void setPrimary_phone(String primary_phone) {
		this.Primary_phone = primary_phone;
	}

	public String getSecondary_phone() {
		return Secondary_phone;
	}

	public void setSecondary_phone(String secondary_phone) {
		this.Secondary_phone = secondary_phone;
	}

	public String getOpen_time() {
		return Open_time;
	}

	public void setOpen_time(String open_time) {
		this.Open_time = open_time;
	}

	public String getClosing_time() {
		return Closing_time;
	}

	public void setClosing_time(String closing_time) {
		this.Closing_time = closing_time;
	}

	public String getHotel_status() {
		return Hotel_status;
	}

	public void setHotel_status(String hotel_status) {
		this.Hotel_status = hotel_status;
	}

	public String getNotice() {
		return Notice;
	}

	public void setNotice(String notice) {
		this.Notice = notice;
	}

	public String getThumbnailUrl() {
		return ThumbnailUrl;
	}

	public void setThumbnailUrl(String thumbnailUrl) {
		this.ThumbnailUrl = thumbnailUrl;
	}

	public String getReviews() {
		return Reviews_count;
	}

	public void setReviews(String reviews_count) {
		this.Reviews_count = reviews_count;
	}

	/*
	 * public ArrayList<String> getCuisine() { return Cuisine; }
	 * 
	 * public void setCuisine(ArrayList<String> cuisine) { this.Cuisine =
	 * cuisine; }
	 */

	public String getCuisine() {
		return Cuisine;
	}

	public void setCuisine(String cuisine) {
		this.Cuisine = cuisine;
	}

	public String getEmail() {
		return Email;
	}

	public void setEmail(String email) {
		this.Email = email;
	}

	public String getLogin() {
		return Login;
	}

	public void setLogin(String login) {
		this.Login = login;
	}

	public String getPassword() {
		return Password;
	}

	public void setPassword(String password) {
		this.Password = password;
	}

	public String getReg_date() {
		return Reg_date;
	}

	public void setReg_date(String reg_date) {
		this.Reg_date = reg_date;
	}

	public String getAgent_status() {
		return Agent_status;
	}

	public void setAgent_status(String agent_status) {
		this.Agent_status = agent_status;
	}

	public String getMembership() {
		return Membership;
	}

	public void setMembership(String membership) {
		this.Membership = membership;
	}

	public String getMin_order() {
		return Min_order;
	}

	public void setMin_order(String Min_order) {
		this.Min_order = Min_order;
	}
	
	public String getDelivery_charge() {
		return Delivery_charge;
	}

	public void setDelivery_charge(String Delivery_charge) {
		this.Delivery_charge = Delivery_charge;
	}
	
	public String getHotel_loc() {
		return Hotel_loc;
	}

	public void setHotel_loc(String Hotel_loc) {
		this.Hotel_loc = Hotel_loc;
	}
	
	public String getHotel_loc_id() {
		return Hotel_loc_id;
	}

	public void setHotel_loc_id(String Hotel_loc_id) {
		this.Hotel_loc_id = Hotel_loc_id;
	}
	
	public String getHotel_loc_type() {
		return Hotel_loc_type;
	}

	public void setHotel_loc_type(String Hotel_loc_type) {
		this.Hotel_loc_type = Hotel_loc_type;
	}
	
	public String getHotel_loc_status() {
		return Hotel_loc_status;
	}

	public void setHotel_loc_status(String Hotel_loc_status) {
		this.Hotel_loc_status = Hotel_loc_status;
	}

	@Override
	public String toString() {
		return "RestaurantListModel [Id = " + Id + ", Agent_Id = " + Agent_Id
				+ ", Agent_Fullname = " + Agent_Fullname
				+ ", Agent_Lastname = " + Agent_Lastname + ", City = " + City
				+ ", State = " + State + ", Country = " + Country
				+ ", Rest_name = " + Rest_name + ", Rest_add = " + Rest_add
				+ ", Primary_phone = " + Primary_phone + ", Secondary_phone = "
				+ Secondary_phone + ", Open_time = " + Open_time
				+ ", Closing_time = " + Closing_time + ", Hotel_status = "
				+ Hotel_status + ", Notice = " + Notice + ", ThumbnailUrl = "
				+ ThumbnailUrl + ", Reviews = " + Reviews_count
				+ ", Cuisine = " + Cuisine + ", Email = " + Email
				+ ", Login = " + Login + ", Password = " + Password
				+ ", Reg_date = " + Reg_date + ", Agent_status = "
				+ Agent_status + ", Membership = " + Membership
				+ ", Min_order = " + Min_order 
				+ ", Delivery_charge = " + Delivery_charge 
				+ ", Hotel_location = " + Hotel_loc
				+ ", Hotel_location_id = " + Hotel_loc_id
				+ ", Hotel_location_type = " + Hotel_loc_type
				+ ", Hotel_locationstatus = " + Hotel_loc_status+"]";
	}

}
