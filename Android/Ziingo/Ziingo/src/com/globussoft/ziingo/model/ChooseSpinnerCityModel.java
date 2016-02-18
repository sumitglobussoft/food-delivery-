package com.globussoft.ziingo.model;

public class ChooseSpinnerCityModel {
	
	
	public String Spinner_City = "";
	public String Spinner_City_id = "";
	
	public String getSpinner_City() {
		return Spinner_City;
	}

	public void setSpinner_City(String spinner_City) {
		Spinner_City = spinner_City;
	}

	
	public String getSpinner_City_id() {
		return Spinner_City_id;
	}

	public void setSpinner_City_id(String spinner_City_id) {
		Spinner_City_id = spinner_City_id;
	}

	
	

	public ChooseSpinnerCityModel() {
	}

	public ChooseSpinnerCityModel(String Spinner_State, String Spinner_City_id) {
		
		this.Spinner_City = Spinner_City;
		this.Spinner_City_id = Spinner_City_id;
		
	}

	

	@Override
	public String toString() {
		return "ChooseSpinnerCityModel [ Spinner_State = "+ Spinner_City+ ", Spinner_City = " + Spinner_City_id
				+ "]";
	}





}
