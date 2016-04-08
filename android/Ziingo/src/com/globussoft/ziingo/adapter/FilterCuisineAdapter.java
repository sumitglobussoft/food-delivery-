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
import com.globussoft.ziingo.fragment.Filter_Fragment;
import com.globussoft.ziingo.model.ChooseCountryModel;
import com.globussoft.ziingo.model.FilterModel_Cuisine;
import com.globussoft.ziingo.utills.Singleton;

public class FilterCuisineAdapter extends BaseExpandableListAdapter {

	private Context _context;
	private List<String> _listDataHeader; // header titles
	// child data in format of header title, child title
	private HashMap<String, List<FilterModel_Cuisine>> _listDataChild;
	//private HashMap<String, List<String>> _listDataChild;
	private List<FilterModel_Cuisine>  listDataChild_Id = new ArrayList<FilterModel_Cuisine>();
	public static String sstring="";
	ArrayList<Integer> trustedList = new ArrayList<Integer>();
	
	//public static CheckBox chkbx;
	
	public static ImageView open, close;
	
	public FilterCuisineAdapter(Context context, List<String> listDataHeader,
			HashMap<String, List<FilterModel_Cuisine>> listChildData) {
		_context = context;
		_listDataHeader = listDataHeader;
		_listDataChild = listChildData;
	}

	@Override
	public int getGroupCount() {
		 return _listDataHeader.size();
	}

	@Override
	public int getChildrenCount(int groupPosition) {
		
		int pos=0;
		try
		{
		 pos = _listDataChild.get(this._listDataHeader.get(groupPosition)).size();
		}
		catch(NullPointerException exp){
			
		}
		return pos;

	}

	@Override
	public Object getGroup(int groupPosition) {
		return _listDataHeader.get(groupPosition);
	}

	@Override
	public Object getChild(int groupPosition, int childPosititon) {
		return _listDataChild.get(this._listDataHeader.get(groupPosition))
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
			View convertView, ViewGroup parent) 
	{
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
	public View getChildView(final int groupPosition, final int childPosition, boolean isLastChild, View convertView, ViewGroup parent) 
	{

		final FilterModel_Cuisine filterCuisineModel = (FilterModel_Cuisine) getChild(groupPosition, childPosition);
		
		
		//final FilterModel_Cuisine f1 = listDataChild_Id.get(childPosition);
		
		if (convertView == null) 
		{
			LayoutInflater infalInflater = (LayoutInflater) this._context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			convertView = infalInflater.inflate(R.layout.exblistitem, null);
		}

		TextView txtListChild = (TextView) convertView.findViewById(R.id.lblListItem);
		final CheckBox chkbx  = (CheckBox) convertView.findViewById(R.id.fil_chk);

		txtListChild.setText(filterCuisineModel.getfilter_cuisine_name());
		
		txtListChild.setOnClickListener(new OnClickListener() 
		{			
			@Override
			public void onClick(View v) 
			{
				// TODO Auto-generated method stub
				
				if (!chkbx.isChecked()) 
				{					  
					chkbx.setChecked(true);	
					System.out.println("cuisine selected");
					
					if(!Singleton.filterCusineId_list.contains(Filter_Fragment.favCuisine.get(childPosition).getFilter_cuisine_id()))
					{
						Singleton.filterCusineId_list.add(Filter_Fragment.favCuisine.get(childPosition).getFilter_cuisine_id());
						Singleton.filterCusineName_list.add(Filter_Fragment.favCuisine.get(childPosition).getfilter_cuisine_name());
						Singleton.filterCusineName_list.add(", ");
					}
					
					System.out.println("Singleton.fltrCuisineId_list >>> "+ Singleton.filterCusineId_list);
					System.out.println("Singleton.filterCusineName_list >>> "+Singleton.filterCusineName_list);
				}
				else 
				{
					chkbx.setChecked(false);
					
					System.out.println("cuisine de-selected");
					
					if(Singleton.filterCusineId_list.contains(Filter_Fragment.favCuisine.get(childPosition).getFilter_cuisine_id()))
					{
						Singleton.filterCusineId_list.remove(Filter_Fragment.favCuisine.get(childPosition).getFilter_cuisine_id());
						Singleton.filterCusineName_list.remove(Filter_Fragment.favCuisine.get(childPosition).getfilter_cuisine_name());
						Singleton.filterCusineName_list.remove(", ");
					}
					
					System.out.println("Singleton.fltrCsineId_list >>> "+ Singleton.filterCusineId_list);
					System.out.println("Singleton.filterCusineName_list >>> "+ Singleton.filterCusineName_list);
					
				}	
				
				
				
				StringBuilder string = new StringBuilder();				
				for (Object str : Singleton.filterCusineName_list ) {
				    string.append(str.toString());	
				   	}
				
				sstring = string.toString();
				
				System.out.println("sstring >>>>>>>> "+ sstring);
				
				if(sstring.contains("cuisine"))
				{
					System.out.println("Yes contains");
					sstring = sstring.replaceAll(" cuisine", "");
				}
				else
				{
					System.out.println("Does not contain");
				}
				
				sstring = sstring.substring(0, sstring.lastIndexOf(","));
				System.out.println("Singleton.filterCusineName_list (string )>>> "+sstring);			
			}
		});
						
		return convertView;
	}

	@Override
	public boolean isChildSelectable(int groupPosition, int childPosition) {
		// TODO Auto-generated method stub
		return true;
	}
	
}
