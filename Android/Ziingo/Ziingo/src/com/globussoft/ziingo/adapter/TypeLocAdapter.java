package com.globussoft.ziingo.adapter;

import java.util.List;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.globussoft.ziingo.R;
import com.globussoft.ziingo.model.TypeLocModel;

public class TypeLocAdapter extends BaseAdapter{
	
	public Context context;
	public LayoutInflater inflater;
	public  List<TypeLocModel> recLocListItems;
	

	public TypeLocAdapter(Context context,
			List<TypeLocModel> recLocListItems) {
		this.context = context;
		this.recLocListItems = recLocListItems;
		
	}

	@Override
	public int getCount() {
		// TODO Auto-generated method stub
		return recLocListItems.size();
	}

	@Override
	public Object getItem(int location) {
		// TODO Auto-generated method stub
		return recLocListItems.get(location);
	}

	@Override
	public long getItemId(int position) {
		// TODO Auto-generated method stub
		return position;
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		// TODO Auto-generated method stub
		if (inflater == null)
			inflater = (LayoutInflater) context
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		if (convertView == null)
			convertView = inflater.inflate(R.layout.type_loc_list, null);

		TextView location = (TextView) convertView.findViewById(R.id.txt_recent_loc);		
		TextView address = (TextView) convertView.findViewById(R.id.loc2);
		
		TypeLocModel m = recLocListItems.get(position);

		location.setText(m.getLocation());
		address.setText(m.getAddress());	

		return convertView;
	}
	

}
