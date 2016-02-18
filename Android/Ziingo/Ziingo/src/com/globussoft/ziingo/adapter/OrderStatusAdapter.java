package com.globussoft.ziingo.adapter;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseExpandableListAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.globussoft.ziingo.R;
import com.globussoft.ziingo.model.BagModel;
import com.globussoft.ziingo.utills.Singleton;

public class OrderStatusAdapter extends BaseExpandableListAdapter {


	private Context _context;
	private List<String> _listDataHeader; // header titles
	// child data in format of header title, child title
	private HashMap<String, List<BagModel>> _listDataChild;
	
	
	ArrayList<Integer> trustedList = new ArrayList<Integer>();
	
	public ImageView open, close;
	public TextView lblListHeader, lblListHeader1 ;
	
	public OrderStatusAdapter(Context context, List<String> listDataHeader,
			HashMap<String, List<BagModel>> listChildData) {
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
	            convertView = infalInflater.inflate(R.layout.or_exblistheader, null);
	        }
	 
	        lblListHeader = (TextView) convertView.findViewById(R.id.or_listHeader);
	        lblListHeader1 = (TextView) convertView.findViewById(R.id.or_listHeader1);
	       // lblListHeader.setText(headerTitle);
	        
	        open = (ImageView) convertView.findViewById(R.id.or_filSelect);
	        close = (ImageView) convertView.findViewById(R.id.or_filSelect1);	 
	       
	        return convertView;
	}
	

	@Override
	public View getChildView(final int groupPosition, final int childPosition,
			boolean isLastChild, View convertView, ViewGroup parent) {

		final BagModel childText = (BagModel) getChild(groupPosition, childPosition);
		
		if (convertView == null) {
			LayoutInflater infalInflater = (LayoutInflater) this._context
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			convertView = infalInflater.inflate(R.layout.or_exblistitem, null);
		}

		TextView or_item_qnt = (TextView) convertView.findViewById(R.id.or_qnt);
		TextView or_item_amt = (TextView) convertView.findViewById(R.id.or_item_amt);
		TextView or_item_name = (TextView) convertView.findViewById(R.id.or_item);
		
		or_item_qnt.setText(childText.getBag_product_qnt()+"x");
		or_item_amt.setText(Singleton.currency+ " " + childText.getBag_product_price());
		or_item_name.setText(childText.getBag_product_name());
						
		return convertView;
	}

	@Override
	public boolean isChildSelectable(int groupPosition, int childPosition) {
		// TODO Auto-generated method stub
		return true;
	}
	
	
}
