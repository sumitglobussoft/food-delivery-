package com.globussoft.ziingo.adapter;

import java.util.List;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import com.globussoft.ziingo.R;
import com.globussoft.ziingo.model.ChooseSpinnerStateModel;

public class ChooseSpinnerStateAdapter extends ArrayAdapter 
{
	
	private Context context;
    private List objects;
   
   ChooseSpinnerStateModel tempValues=null;
    LayoutInflater inflater;
     

	public ChooseSpinnerStateAdapter(Context context, int resource, List objects) {
		super(context, resource, objects);
		// TODO Auto-generated constructor stub
		
		 /********** Take passed values **********/
		this.context = context;
		this.objects = objects;
      
    
        /***********  Layout inflator to call external xml layout () **********************/
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
    	
    	/**/
        /********** Inflate spinner_rows.xml file for each row ( Defined below ) ************/
        View row = inflater.inflate(R.layout.spinner_rows, parent, false);
         
        /***** Get each Model object from Arraylist ********/
        tempValues = null;
        tempValues = (ChooseSpinnerStateModel) objects.get(position);
         
        TextView label  = (TextView)row.findViewById(R.id.spinner_txt);
        
        label.setText(tempValues.getSpinner_State());
        /*if(position==0){
            
            // Default selected Spinner item 
            label.setText("Select State");
            
        }
        else
        {
            // Set values for spinner each row 
        	
        	label.setText(tempValues.getSpinner_State());
        	
         }   */
        
        return row;
      
      }
	
}
