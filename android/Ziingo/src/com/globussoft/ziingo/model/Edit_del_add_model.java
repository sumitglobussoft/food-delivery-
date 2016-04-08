package com.globussoft.ziingo.model;

public class Edit_del_add_model {


	public String Del_userName = "";	
	public String Del_address1 = "";
	public String Del_address2 = "";
	public String Del_contact_country_code = "";
	public String Del_contact_number = "";
	public String Del_landmark = "";
	public String Del_location = "";
	

	public String Del_city = "";
	public String Del_state = "";
	public String Del_country = "";
	public String Del_pincode = "";
	public String Del_address_ID = "";
	
	public boolean isChecked;
	
	
	public boolean isChecked() {
		return isChecked;
	}

	public void setChecked(boolean isChecked) {
		this.isChecked = isChecked;
	}

	public Edit_del_add_model() {
	}

	public Edit_del_add_model(String Del_userName, String Del_address1,
			String Del_address2, String Del_contact_country_code, String Del_contact_number,
			String Del_landmark, String Del_city, String Del_state, String Del_country, 
			String Del_pincode, String Del_address_ID) {

		this.Del_userName = Del_userName;
		this.Del_address1 = Del_address1;
		this.Del_address2 = Del_address2;
		this.Del_contact_country_code = Del_contact_country_code;
		this.Del_contact_number = Del_contact_number;
		this.Del_landmark = Del_landmark;
		this.Del_city = Del_city;		
		this.Del_state = Del_state;
		this.Del_country = Del_country;
		this.Del_pincode = Del_pincode;
		this.Del_address_ID = Del_address_ID;

	}	
	
	
	public String getDel_userName() {
		return Del_userName;
	}

	public void setDel_userName(String Del_userName) {
		this.Del_userName = Del_userName;
	}
	
	public String getDel_location() {
		return Del_location;
	}

	public void setDel_location(String del_location) {
		Del_location = del_location;
	}
	
	public String getDel_address1() {
		return Del_address1;
	}

	public void setDel_address1(String Del_address1) {
		this.Del_address1 = Del_address1;
	}
	
	public String getDel_address2() {
		return Del_address2;
	}

	public void setDel_address2(String Del_address2) {
		this.Del_address2 = Del_address2;
	}

	public String getDel_contact_country_code() {
		return Del_contact_country_code;
	}

	public void setDel_contact_country_code(String Del_contact_country_code) {
		this.Del_contact_country_code = Del_contact_country_code;
	}

	public String getDel_contact_number() {
		return Del_contact_number;
	}

	public void setDel_contact_number(String Del_contact_number) {
		this.Del_contact_number = Del_contact_number;
	}

	public String getDel_landmark() {
		return Del_landmark;
	}

	public void setDel_landmark(String Del_landmark) {
		this.Del_landmark = Del_landmark;
	}

	public String getDel_city() {
		return Del_city;
	}

	public void setDel_city(String Del_city) {
		this.Del_city = Del_city;
	}

	public String getDel_state() {
		return Del_state;
	}

	public void setDel_state(String Del_state) {
		this.Del_state = Del_state;
	}

	public String getDel_country() {
		return Del_country;
	}

	public void setDel_country(String Del_country) {
		this.Del_country = Del_country;
	}
	
	public String getDel_pincode() {
		return Del_pincode;
	}

	public void setDel_pincode(String Del_pincode) {
		this.Del_pincode = Del_pincode;
	}	
	
	public String getDel_address_ID() {
		return Del_address_ID;
	}

	public void setDel_address_ID(String del_address_ID) {
		Del_address_ID = del_address_ID;
	}

}
