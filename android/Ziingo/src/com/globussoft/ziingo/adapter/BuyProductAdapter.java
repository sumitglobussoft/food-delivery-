package com.globussoft.ziingo.adapter;

import java.util.List;

import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.NetworkImageView;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.api.AppController;
import com.globussoft.ziingo.model.BuyProductModel;
import com.globussoft.ziingo.model.ProductListModel;



import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

public class BuyProductAdapter extends BaseAdapter {
	

	private Activity activity;
	private LayoutInflater inflater;
	private List<BuyProductModel> buyproductListItems;
	
	ImageLoader imageLoader = AppController.getInstance().getImageLoader();

	public BuyProductAdapter(Activity activity,
			List<BuyProductModel> buyproductListItems) {
		this.activity = activity;
		this.buyproductListItems = buyproductListItems;
	}

	@Override
	public int getCount() {
		return buyproductListItems.size();
	}

	@Override
	public Object getItem(int location) {
		return buyproductListItems.get(location);
	}

	@Override
	public long getItemId(int position) {
		return position;
	}

	@Override
	public View getView(int position, View convertView, ViewGroup parent) {

		if (inflater == null)
			inflater = (LayoutInflater) activity
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		if (convertView == null)
			convertView = inflater.inflate(R.layout.buy_food, null);

		if (imageLoader == null)
			imageLoader = AppController.getInstance().getImageLoader();
		
		NetworkImageView food_img = (NetworkImageView) convertView.findViewById(R.id.buy_food_image);
		TextView food_name = (TextView) convertView.findViewById(R.id.fooditem_name);
		TextView food_desc = (TextView) convertView.findViewById(R.id.food_desc);
		TextView basic_price  = (TextView) convertView.findViewById(R.id.basicprice_amt);
		TextView food_quantity = (TextView) convertView.findViewById(R.id.qnty_cnt);
		TextView food_tl_amt = (TextView) convertView.findViewById(R.id.total);
	//	TextView food_subtl_amt = (TextView) convertView.findViewById(R.id.sub_total);
	//	TextView delivery_charge = (TextView) convertView.findViewById(R.id.del_chrg);
		
		

		// getting product data for the row
		BuyProductModel m = buyproductListItems.get(position);

		// thumbnail image
	    food_img.setImageUrl(m.getFood_image(), imageLoader);

		// Product_name
		food_name.setText(m.getFood_name());
		
		// Product_desc
		food_desc.setText(m.getFood_desc());
		
		basic_price.setText(m.getFood_price());
		
		food_quantity.setText(m.getFood_quantity());
		
		food_tl_amt.setText(m.getFood_total_amt());
		
	//	food_subtl_amt.setText(m.getFood_subtotal_amt());
		
    // delivery_charge.setText(m.getFood_delivery_charge());


		// Reviews
		//reviews.setText("Rating: " + String.valueOf(m.getreviews()));		

		return convertView;
	}



}
