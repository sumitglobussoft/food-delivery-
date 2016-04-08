package com.globussoft.ziingo.model;

public class TypeLocModel {
	
	public String location = "";
	public String address = "";
	
	public TypeLocModel() { 
	}

	public TypeLocModel(String location, String address) {
		
		this.location = location;
		this.address = address;	
		
	}

	public String getLocation() {
		return location;
	}

	public void setLocation(String location) {
		this.location = location;
	}

	public String getAddress() {
		return address;
	}

	public void setAddress(String address) {
		this.address = address;
	}

}
