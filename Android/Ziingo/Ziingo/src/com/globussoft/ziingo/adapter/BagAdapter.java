package com.globussoft.ziingo.adapter;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.json.JSONException;
import org.json.JSONObject;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.NetworkImageView;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.globussoft.ziingo.LoginActivity;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.api.AppController;
import com.globussoft.ziingo.fragment.Bag_Fragment;
import com.globussoft.ziingo.model.BagModel;
import com.globussoft.ziingo.model.BuyProductModel;
import com.globussoft.ziingo.model.MenuListModel;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Handler;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

public class BagAdapter extends BaseAdapter {

	 List<BagModel> bagListItems = new ArrayList<BagModel>();

	AlertDialog.Builder alert;
	private Context context;
	View view;

	ImageLoader imageLoader = AppController.getInstance().getImageLoader();
	
	

	public BagAdapter(Context context, ArrayList<BagModel> bagListItems) {

		System.out.println("context" +context);
		this.context = context;
		this.bagListItems = bagListItems;
		// imageLoader = new ImageLoader(context);

	}

	@Override
	public int getCount() {
		// TODO Auto-generated method stub
		return bagListItems.size();
	}

	@Override
	public Object getItem(int location) {
		// TODO Auto-generated method stub
		return bagListItems.get(location);
	}

	@Override
	public long getItemId(int position) {
		// TODO Auto-generated method stub
		return position;
	}

	@Override
	public View getView(final int position, View convertView, ViewGroup parent) {
		// TODO Auto-generated method stub

		LayoutInflater inflater = (LayoutInflater) context
				.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

		/*
		 * inflater = (LayoutInflater) context
		 * .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		 */

		// convertView = mInflater.inflate(R.layout.cart_item, parent, false);

		if (convertView == null)
			convertView = inflater.inflate(R.layout.bag_list, null);

		TextView Bag_product_name = (TextView) convertView.findViewById(R.id.product_name_txt);
		TextView Bag_product_price = (TextView) convertView.findViewById(R.id.pr_price);
		TextView Bag_Product_qnt = (TextView) convertView.findViewById(R.id.product_qnty);
		final ImageView Product_rmv = (ImageView) convertView.findViewById(R.id.pr_rmv);
		NetworkImageView Product_image = (NetworkImageView) convertView.findViewById(R.id.thumbnail);

		// getting product data for the row
		BagModel m = bagListItems.get(position);

		Bag_product_name.setText(m.getBag_product_name());
		Bag_product_price.setText(Singleton.currency + m.getBag_product_price());
		Bag_Product_qnt.setText(m.getBag_product_qnt());
		Product_image.setImageUrl(m.getBag_product_image(), imageLoader);

		Product_rmv.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				// ShowDialog();

				Singleton.product_sl_no = bagListItems.get(position).getBag_product_sl_no();
				Singleton.cart_product_amt = bagListItems.get(position).getBag_product_price();
				
				System.out.println("Singleton.product_sl_no === "+Singleton.product_sl_no);
				System.out.println("Singleton.user_id === "+ Singleton.user_id);
			
				bagListItems.remove(position);
				Singleton.product_cartid.remove(Singleton.product_sl_no);  // removed from list
				System.out.println("Remaining Singleton.product_cartid == "+ Singleton.product_cartid); //list
				
				DelfromBag(Singleton.user_id, Singleton.product_sl_no);
				
				Singleton.cart_subtotal_amt = Integer.toString(((Integer.parseInt(Singleton.cart_subtotal_amt))-
											  (Integer.parseInt(Singleton.cart_product_amt))));
				Singleton.cart_total_amt = Integer.toString(((Integer.parseInt(Singleton.cart_subtotal_amt))+
						  (Integer.parseInt(Singleton.cart_hotel_del_chrg))));
				
				Bag_Fragment.sub_total.setText(Singleton.currency +" "+Singleton.cart_subtotal_amt);
				Bag_Fragment.bag_total.setText(Singleton.currency +" "+Singleton.cart_total_amt);
				
				if((Integer.parseInt(Singleton.cart_total_amt)) >= (Integer.parseInt(Singleton.min_order))) 
				{
					Bag_Fragment.min_order_amt.setVisibility(View.GONE);
				}
				else
				{
					Bag_Fragment.min_order_amt.setVisibility(View.VISIBLE);
					
				}
				
				if(getCount() == 0)
				{
					Bag_Fragment.no_bag_items.setVisibility(View.VISIBLE);
					Bag_Fragment.sub_total.setText(Singleton.currency +" 0");
					Bag_Fragment.bag_total.setText(Singleton.currency +" 0");
					Bag_Fragment.del_chrg.setText(Singleton.currency +" 0");
				}
				
				// bagAdaptor.notifyDataSetChanged();
			    
				
			}
		});

		return convertView;
	}

	public void DelfromBag(final String user_id, final String product_sl_no) {

		RequestQueue queue = Volley.newRequestQueue(context);
		StringRequest sr = new StringRequest(Request.Method.POST,
				ConstantUrl.Url_main + ConstantUrl.Url_RemoveOrderToCart,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {							

							JSONObject json = new JSONObject(response);
							System.out.println("Delete from Bag" + response);

							String msg = json.getString("message");
							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) {

								String data = json.getString("data");
								Toast.makeText(context.getApplicationContext(),"Product successfully deleted from bag",
										Toast.LENGTH_SHORT).show();
							}

							else {

								Toast.makeText(context.getApplicationContext(),	msg, Toast.LENGTH_SHORT).show();
							}

						} catch (JSONException e) {
							// TODO Auto-generated catch block
							e.printStackTrace();
						}

						notifyDataSetChanged();
						

					}

				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {
						// VolleyLog.d(TAG, "Error: " + error.getMessage());
						System.out.println("Error : " + error);
						// hidePDialog();

					}
				}) {
			@Override
			protected Map<String, String> getParams() {
				Map<String, String> params = new HashMap<String, String>();
				params.put("user_id", user_id);
				params.put("cart_id", product_sl_no);

				return params;
			}

			@Override
			public Map<String, String> getHeaders() throws AuthFailureError {
				Map<String, String> params = new HashMap<String, String>();
				params.put("Content-Type", "application/x-www-form-urlencoded");
				return params;
			}
		};

		queue.add(sr);

	}

	/*
	 * public void ShowDialog() { alert = new
	 * AlertDialog.Builder(context.getApplicationContext());
	 * 
	 * //LayoutInflater inflater = context.getLayoutInflater(); View dialogView
	 * = inflater.inflate(R.layout.dialog_reg, null); alert.setView(dialogView);
	 * 
	 * alert.setTitle("Do you want to remove this item from bag?");
	 * alert.setPositiveButton("Yes", new DialogInterface.OnClickListener() {
	 * public void onClick(DialogInterface dialog1, int whichButton) {
	 * 
	 * 
	 * 
	 * } }); alert.setNegativeButton("No", new DialogInterface.OnClickListener()
	 * { public void onClick(DialogInterface dialog1, int whichButton) {
	 * 
	 * 
	 * } }); alert.show();
	 * 
	 * }
	 */

}
