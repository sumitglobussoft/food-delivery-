package com.globussoft.ziingo.model;

public class ChooseCountryModel {	


	public String country ;
	
	public boolean isChecekd;
	public boolean isChecekd() {
		return isChecekd;
	}
	
	public void setChecekd(boolean isChecekd) {
		this.isChecekd = isChecekd;
	}
		
	public ChooseCountryModel() {
	}

	public ChooseCountryModel(String country) {
		this.country = country;		
	}

	public String getcountry() {
		return country;
	}

	public void setcountry(String country) {
		this.country = country;
	}

	
	@Override
	public String toString() {
		return "ChooseCountryModel [country = " + country +	"]";
	}



}
