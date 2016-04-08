package com.globussoft.ziingo.model;

public class FilterModel_Cuisine {

	public String filter_cuisine_name = "";
	public String filter_cuisine_id = "";
		
	public boolean isChecekd;
	public boolean isChecekd() {
		return isChecekd;
	}
	
	public void setChecekd(boolean isChecekd) {
		this.isChecekd = isChecekd;
	}
	
	
	public FilterModel_Cuisine() {
	}

	public FilterModel_Cuisine(String filter_cuisine, String filter_cuisine_id) {

		this.filter_cuisine_name = filter_cuisine;
		this.filter_cuisine_id = filter_cuisine_id;
		
	}
	

	public String getfilter_cuisine_name() {
		return filter_cuisine_name;
	}

	public void setfilter_cuisine_name(String filter_cuisine_name) {
		this.filter_cuisine_name = filter_cuisine_name;
	}
	
	public String getFilter_cuisine_id() {
		return filter_cuisine_id;
	}

	public void setFilter_cuisine_id(String filter_cuisine_id) {
		this.filter_cuisine_id = filter_cuisine_id;
	}


	@Override
	public String toString() {
		return "FilterModel [filter_cuisine_name = " + filter_cuisine_name + 
				"filter_cuisine_id = " + filter_cuisine_id +"]";
	}



}
