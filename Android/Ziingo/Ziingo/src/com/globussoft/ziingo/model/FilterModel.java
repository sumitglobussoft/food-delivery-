package com.globussoft.ziingo.model;

public class FilterModel {

	public String filter_cuisine = "";
	public String filter_cuisine_id = "";
	public String filter_cuisine_status = "";

	public String filter_rest = "";
	public String filter_rest_id = "";
	public String filter_rest_status = "";

	public FilterModel() {
	}

	public FilterModel(String filter_cuisine, String filter_cuisine_id,
			String filter_cuisine_status, String filter_rest,
			String filter_rest_id, String filter_rest_status) {

		this.filter_cuisine = filter_cuisine;
		this.filter_cuisine_id = filter_cuisine_id;
		this.filter_cuisine_status = filter_cuisine_status;

		this.filter_rest = filter_rest;
		this.filter_rest_id = filter_rest_id;
		this.filter_rest_status = filter_rest_status;

	}

	public String getFilter_cuisine() {
		return filter_cuisine;
	}

	public void setFilter_cuisine(String filter_cuisine) {
		this.filter_cuisine = filter_cuisine;
	}

	public String getFilter_rest() {
		return filter_rest;
	}

	public void setFilter_rest(String filter_rest) {
		this.filter_rest = filter_rest;
	}

	public String getFilter_rest_id() {
		return filter_rest_id;
	}

	public void setFilter_rest_id(String filter_rest_id) {
		this.filter_rest_id = filter_rest_id;
	}

	public String getFilter_rest_status() {
		return filter_rest_status;
	}

	public void setFilter_rest_status(String filter_rest_status) {
		this.filter_rest_status = filter_rest_status;
	}

	public String getFilter_cuisine_id() {
		return filter_cuisine_id;
	}

	public void setFilter_cuisine_id(String filter_cuisine_id) {
		this.filter_cuisine_id = filter_cuisine_id;
	}

	public String getFilter_cuisine_status() {
		return filter_cuisine_status;
	}

	public void setFilter_cuisine_status(String filter_cuisine_status) {
		this.filter_cuisine_status = filter_cuisine_status;
	}

	@Override
	public String toString() {
		return "FilterModel [filter_cuisine = " + filter_cuisine
				+ "filter_cuisine_id = " + filter_cuisine_id
				+ "filter_cuisine_status = " + filter_cuisine_status + 
				"filter_rest = " + filter_rest
				+ "filter_rest_id = " + filter_rest_id
				+ "filter_rest_status = " + filter_rest_status+"]";
	}

}
