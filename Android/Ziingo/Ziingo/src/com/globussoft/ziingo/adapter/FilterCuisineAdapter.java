package com.globussoft.ziingo.adapter;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.HashSet;
import java.util.List;

import android.content.Context;
import android.graphics.Typeface;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.BaseExpandableListAdapter;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.ImageView;
import android.widget.TextView;

import com.globussoft.ziingo.R;
import com.globussoft.ziingo.model.ChooseCountryModel;
import com.globussoft.ziingo.model.FilterModel_Cuisine;

public class FilterCuisineAdapter extends BaseExpandableListAdapter {

	private Context _context;
	private List<String> _listDataHeader; // header titles
	// child data in format of header title, child title
	private HashMap<String, List<FilterModel_Cuisine>> _listDataChild;
	//private HashMap<String, List<String>> _listDataChild;
	
	ArrayList<Integer> trustedList = new ArrayList<Integer>();
	
	public static  ImageView open, close;
	
	public FilterCuisineAdapter(Context context, List<String> listDataHeader,
			HashMap<String, List<FilterModel_Cuisine>> listChildData) {
		this._context = context;
		this._listDataHeader = listDataHeader;
		this._listDataChild = listChildData;
	}

	@Override
	public int getGroupCount() {
		 return this._listDataHeader.size();
	}

	@Override
	public int getChildrenCount(int groupPosition) {
		return this._listDataChild.get(this._listDataHeader.get(groupPosition))
				.size();
	}

	@Override
	public Object getGroup(int groupPosition) {
		return this._listDataHeader.get(groupPosition);
	}

	@Override
	public Object getChild(int groupPosition, int childPosititon) {
		return this._listDataChild.get(this._listDataHeader.get(groupPosition))
				.get(childPosititon);
	}

	@Override
	public long getGroupId(int groupPosition) {
		return groupPosition;
	}

	@Override
	public long getChildId(int groupPosition, int childPosition) {
		return childPosition;
	}

	@Override
	public boolean hasStableIds() {
		// TODO Auto-generated method stub
		 return false;
	}

	@Override
	public View getGroupView(int groupPosition, boolean isExpanded,
			View convertView, ViewGroup parent) {
		 String headerTitle = (String) getGroup(groupPosition);
	        if (convertView == null) 
	        {
	            LayoutInflater infalInflater = (LayoutInflater) this._context
	                    .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
	            convertView = infalInflater.inflate(R.layout.exblistheader, null);
	        }
	 
	        TextView lblListHeader = (TextView) convertView.findViewById(R.id.lblListHeader);
	        lblListHeader.setTypeface(null, Typeface.BOLD);
	        lblListHeader.setText(headerTitle);
	        
	        open = (ImageView) convertView.findViewById(R.id.filSelect);
	        close = (ImageView) convertView.findViewById(R.id.filSelect1);	 
	       
	        return convertView;
	}
	

	@Override
	public View getChildView(final int groupPosition, final int childPosition,
			boolean isLastChild, View convertView, ViewGroup parent) {

		final FilterModel_Cuisine childText = (FilterModel_Cuisine) getChild(groupPosition, childPosition);
		
		if (convertView == null) {
			LayoutInflater infalInflater = (LayoutInflater) this._context
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			convertView = infalInflater.inflate(R.layout.exblistitem, null);
		}

		TextView txtListChild = (TextView) convertView
				.findViewById(R.id.lblListItem);
		final CheckBox chkbx = (CheckBox) convertView.findViewById(R.id.fil_chk);


		txtListChild.setText(childText.getfilter_cuisine());
		
		txtListChild.setOnClickListener(new OnClickListener() {
			
			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				
				if (!chkbx.isChecked()) 
				{					
					chkbx.setChecked(true);		
					
				}
				else 
				{
					chkbx.setChecked(false);
				}	
				
			//	chkbx.setOnCheckedChangeListener(new CheckchangeListener(groupPosition) );

			}
		});
		
		//FilterModel_Cuisine m = FilterModel_Cuisine.get(position);
		//country_name.setText(m.getcountry());

	
		/*if (trustedList.get(groupPosition) == 1)
		{
			chkbx.setChecked(true);
		}
        else
        {
        	chkbx.setChecked(false);
        }*/
				
		return convertView;
	}

	@Override
	public boolean isChildSelectable(int groupPosition, int childPosition) {
		// TODO Auto-generated method stub
		return true;
	}
	
	/*class CheckchangeListener implements OnCheckedChangeListener {
        private int position;

        public CheckchangeListener(int position) {
            // TODO Auto-generated constructor stub

            this.position= position;

        }

        @Override
        public void onCheckedChanged(CompoundButton buttonView,
                boolean isChecked) {
            // TODO Auto-generated method stub
            if (isChecked) {
                //updateyour list and database here
            	
            	System.out.println("cuisine selected");

            } else {
                //updateyour list and database here
            	System.out.println("cuisine deselected");


            }

        }
    }

*/	
}
