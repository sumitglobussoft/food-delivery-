package com.globussoft.ziingo.adapter;

import java.util.HashSet;
import java.util.List;

import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.NetworkImageView;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.api.AppController;
import com.globussoft.ziingo.model.ChooseCountryModel;
import com.globussoft.ziingo.model.RestaurantListModel;

import android.app.Activity;
import android.content.Context;
import android.content.res.ColorStateList;
import android.graphics.Color;
import android.support.v7.widget.AppCompatRadioButton;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.RadioButton;
import android.widget.RelativeLayout;
import android.widget.TextView;

public class ChooseCountryAdapter extends BaseAdapter {

	private Context context;
	private LayoutInflater inflater;
	//private List<RestaurantListModel> restListModel;
	private List<ChooseCountryModel> countryListModel;
	
	private HashSet<RestaurantListModel> hscl;
	int selectedPosition = 0;

	public ChooseCountryAdapter(Context context,
			int simpleListItemSingleChoice,
			List<ChooseCountryModel> countryListModel) {
		this.context = context;
		this.countryListModel = countryListModel;

	}

	/*public ChooseCountryAdapter(Context context,
			int chooseCountryList, HashSet<RestaurantListModel> hscl) {
		// TODO Auto-generated constructor stub
		
		this.context = context;
		this.hscl = hscl;
	}*/

	@Override
	public int getCount() {
		return countryListModel.size();
	}

	@Override
	public Object getItem(int location) {
		return countryListModel.get(location);
	}

	@Override
	public long getItemId(int position) {
		return position;
	}

	@Override
	public View getView(final int position, View convertView, ViewGroup parent) {
		// TODO Auto-generated method stub

		if (inflater == null)
			inflater = (LayoutInflater) context
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		if (convertView == null)
		convertView = inflater.inflate(R.layout.choose_country_list, null);

		// RelativeLayout rel_cntry_list = (RelativeLayout)
		// convertView.findViewById(R.id.rel_cntry_list);
		RadioButton rad_btn = (RadioButton) convertView
				.findViewById(R.id.rad_btn);
		TextView country_name = (TextView) convertView
				.findViewById(R.id.country_name);

		//RestaurantListModel m = restListModel.get(position);
		ChooseCountryModel m = countryListModel.get(position);
		country_name.setText(m.getcountry());

		if (m.isChecekd()) {
			rad_btn.setChecked(true);
		}
		else {
			rad_btn.setChecked(false);
		}

		/*
		 * convertView.setOnClickListener(new View.OnClickListener() {
		 * 
		 * @Override public void onClick(View view) {
		 * 
		 * 
		 * selectedPosition = (Integer)view.getTag(); notifyDataSetChanged(); }
		 * });
		 */
		
		return convertView;

	}

}
