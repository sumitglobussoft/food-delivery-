/*package com.globussoft.ziingo.adapter;

import java.util.HashSet;
import java.util.List;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.RadioButton;
import android.widget.TextView;

import com.globussoft.ziingo.R;
import com.globussoft.ziingo.model.ChooseCountryModel;
import com.globussoft.ziingo.model.ChooseSpinnerCityModel;
import com.globussoft.ziingo.model.ChooseSpinnerLocationModel;
import com.globussoft.ziingo.model.CountryCodeModel;
import com.globussoft.ziingo.model.RestaurantListModel;

public class CountryCodeAdapter extends ArrayAdapter{

	
	private Context context;
    private List objects;
   
   CountryCodeModel tempValues=null;
    LayoutInflater inflater;
     

	public CountryCodeAdapter(Context context, int resource, List objects) {
		super(context, resource, objects);
		// TODO Auto-generated constructor stub
		
		 *//********** Take passed values **********//*
		this.context = context;
		this.objects = objects;
      
    
        *//***********  Layout inflator to call external xml layout () **********************//*
        inflater = (LayoutInflater)context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
         
	}
	

    @Override
    public View getDropDownView(int position, View convertView,ViewGroup parent) {
        return getCustomView(position, convertView, parent);
    }
 
    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        return getCustomView(position, convertView, parent);
    }
 
    // This funtion called for each row ( Called data.size() times )
    public View getCustomView(int position, View convertView, ViewGroup parent) {    	
    	
    	
        *//********** Inflate spinner_rows.xml file for each row ( Defined below ) ************//*
        View row = inflater.inflate(R.layout.item_country_drop, parent, false);
         
        *//***** Get each Model object from Arraylist ********//*
        tempValues = null;
        tempValues = (CountryCodeModel) objects.get(position);
        
        ImageView country_flag =  (ImageView)row.findViewById(R.id.image);
        TextView country_name  = (TextView)row.findViewById(R.id.country_name);
        TextView country_code  = (TextView)row.findViewById(R.id.country_code);
        
        country_flag.setImageDrawable(tempValues.getCountry_image());
        country_name.setText(tempValues.getCountry_name());
        country_code.setText(tempValues.getCountry_code());
                
        return row;
      
      }
	




}
*/