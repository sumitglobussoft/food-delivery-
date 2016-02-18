package com.globussoft.ziingo.fragment;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import org.json.JSONArray;
import org.json.JSONObject;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.ExpandableListView;
import android.widget.ExpandableListView.OnChildClickListener;
import android.widget.ExpandableListView.OnGroupCollapseListener;
import android.widget.ExpandableListView.OnGroupExpandListener;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.globussoft.ziingo.R;
import com.globussoft.ziingo.adapter.FilterCuisineAdapter;
import com.globussoft.ziingo.model.FilterModel_Cuisine;
import com.globussoft.ziingo.utills.ConstantUrl;
import com.globussoft.ziingo.utills.Singleton;

public class Filter_Fragment extends Fragment {

	FilterCuisineAdapter FilterlistAdapter;
	// FilterRestNameAdapter FilterlistAdapter2;
	// FilterAdapter FilterlistAdapter;

	ExpandableListView expListView, expListView2;
	List<String> listDataHeader, listDataHeader2;
	// HashMap<String, List<FilterModel>> cuisinelistDataChild;

	HashMap<String, List<FilterModel_Cuisine>> cuisinelistDataChild;
	// HashMap<String, List<FilterModel_RestName>> restNamelistDataChild;

	RelativeLayout rel_sort_rating, rel_pop;
	ImageView sort_rating, sort_pop, sort_rating_Sel, sort_pop_sel;
	TextView reset, apply;
	View rootView;

	// List<FilterModel> favCuisine = new ArrayList<FilterModel>();

	List<FilterModel_Cuisine> favCuisine = new ArrayList<FilterModel_Cuisine>();

	// List<FilterModel_RestName> favRest = new
	// ArrayList<FilterModel_RestName>();

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {

		rootView = inflater.inflate(R.layout.fragment_filter, container, false);
		System.out.println(" Filter Fragment ");

		InitUI();
		return rootView;
	}

	private void InitUI() {
		rel_sort_rating = (RelativeLayout) rootView.findViewById(R.id.rel_sort_rating);
		rel_pop = (RelativeLayout) rootView.findViewById(R.id.rel_sort_pop);
		sort_rating = (ImageView) rootView.findViewById(R.id.sort_rating);
		sort_pop = (ImageView) rootView.findViewById(R.id.pop);
		sort_rating_Sel = (ImageView) rootView.findViewById(R.id.sort_rating1);
		sort_pop_sel = (ImageView) rootView.findViewById(R.id.pop1);
		reset = (TextView) rootView.findViewById(R.id.reset);
		apply = (TextView) rootView.findViewById(R.id.apply);

		// get the listview
		expListView = (ExpandableListView) rootView.findViewById(R.id.lvExp);
		// expListView2 = (ExpandableListView)
		// rootView.findViewById(R.id.lvExp1);

		rel_sort_rating.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				if (Singleton.filter_rating == false) {
					Singleton.filter_rating = true;
					sort_rating.setVisibility(View.INVISIBLE);
					sort_rating_Sel.setVisibility(View.VISIBLE);
					System.out.println("Filter by Rating selected");
				} else {
					Singleton.filter_rating = false;
					sort_rating.setVisibility(View.VISIBLE);
					sort_rating_Sel.setVisibility(View.INVISIBLE);
					System.out.println("Filter by Rating DEselected");
				}
			}
		});

		rel_pop.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub
				if (Singleton.filter_Popularity == false) {
					Singleton.filter_Popularity = true;
					sort_pop.setVisibility(View.INVISIBLE);
					sort_pop_sel.setVisibility(View.VISIBLE);
					System.out.println("Filter by Popularity selected");
				} else {
					Singleton.filter_Popularity = false;
					sort_pop.setVisibility(View.VISIBLE);
					sort_pop_sel.setVisibility(View.INVISIBLE);
					System.out.println("Filter by Popularity DEselected");
				}

			}
		});

		reset.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				// clear the selected data

			}
		});

		apply.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View v) {
				// TODO Auto-generated method stub

				// service .... pass the list of selected data ids

			}
		});
		// Listview on child click listener
		
		

		expListView.setOnGroupExpandListener(new OnGroupExpandListener() {
			
			@Override
			public void onGroupExpand(int groupPosition) {
				// TODO Auto-generated method stub
				
				FilterCuisineAdapter.open.setVisibility(View.INVISIBLE);
				FilterCuisineAdapter.close.setVisibility(View.VISIBLE);
				
			}
		});
		
		expListView.setOnGroupCollapseListener(new OnGroupCollapseListener() {
			
			@Override
			public void onGroupCollapse(int groupPosition) {
				// TODO Auto-generated method stub
				
				FilterCuisineAdapter.open.setVisibility(View.VISIBLE);
				FilterCuisineAdapter.close.setVisibility(View.INVISIBLE);
				
			}
		});
		expListView.setOnChildClickListener(new OnChildClickListener() {

			@Override
			public boolean onChildClick(ExpandableListView parent, View v,
					int groupPosition, int childPosition, long id) {
				// TODO Auto-generated method stub

				for (int i = 0; i < favCuisine.size(); i++) {
					favCuisine.get(i).setChecekd(false);

				}
				favCuisine.get(childPosition).setChecekd(true);

				FilterlistAdapter.notifyDataSetChanged();

				Singleton.filter_Cuisine = favCuisine.get(childPosition).getfilter_cuisine();
				Singleton.filter_Cuisine_id = favCuisine.get(childPosition).getFilter_cuisine_id();
				
				System.out.println("Cuisine ==  " + Singleton.filter_Cuisine);
				System.out.println("Cuisine_ID == "+ Singleton.filter_Cuisine_id);
				System.out.println(listDataHeader.get(groupPosition)
						+ " : "
						+ cuisinelistDataChild.get(
								listDataHeader.get(groupPosition)).get(
								childPosition));
				Toast.makeText(
						getActivity(),
						listDataHeader.get(groupPosition)
								+ " : "
								+ cuisinelistDataChild.get(
										listDataHeader.get(groupPosition)).get(
										childPosition), Toast.LENGTH_SHORT)
						.show();
				return false;
			}
		});

		// preparing list data
		prepareListData();

		FilterlistAdapter = new FilterCuisineAdapter(getActivity(), listDataHeader, cuisinelistDataChild);
		// FilterlistAdapter2 = new FilterRestNameAdapter(getActivity(),
		// listDataHeader2, restNamelistDataChild);
		// setting list adapter
		expListView.setAdapter(FilterlistAdapter);
		// expListView2.setAdapter(FilterlistAdapter2);

		/*
		 * expListView.setOnItemClickListener(new OnItemClickListener() {
		 * 
		 * @Override public void onItemClick(AdapterView<?> parent, View view,
		 * int position, long id) { // TODO Auto-generated method stub
		 * 
		 * 
		 * for (int i = 0; i < favCuisine .size(); i++) {
		 * favCuisine.get(i).setChecekd(false);
		 * 
		 * } favCuisine.get(position).setChecekd(true);
		 * 
		 * FilterlistAdapter.notifyDataSetChanged();
		 * 
		 * Singleton.filter_Cuisine =
		 * favCuisine.get(position).getfilter_cuisine();
		 * System.out.println("Cuisine ==  " + Singleton.filter_Cuisine);
		 * System.
		 * out.println("favCuisine.get(position) ==== "+favCuisine.get(position
		 * ).getFilter_cuisine_id());
		 * 
		 * 
		 * //sharedPrefernces();
		 * 
		 * Intent i = new Intent(Choose_Country.this, MainActivity.class);
		 * startActivity(i);
		 * 
		 * }
		 * 
		 * 
		 * 
		 * 
		 * @Override public void onItemClick(AdapterView<?> parent, View view,
		 * int position, long id) { // TODO Auto-generated method stub
		 * 
		 * System.out.println( listDataHeader.get(position) + " : " +
		 * cuisinelistDataChild.get( listDataHeader.get(position)).get(
		 * position)); Toast.makeText( getActivity(),
		 * listDataHeader.get(position) + " : " + cuisinelistDataChild.get(
		 * listDataHeader.get(position)).get( position), Toast.LENGTH_SHORT)
		 * .show();
		 * 
		 * }
		 * 
		 * 
		 * });
		 */

	}

	/*
	 * Preparing the list data
	 */

	private void prepareListData() {
		listDataHeader = new ArrayList<String>();
		// listDataHeader2 = new ArrayList<String>();

		cuisinelistDataChild = new HashMap<String, List<FilterModel_Cuisine>>();

		// restNamelistDataChild = new HashMap<String,
		// List<FilterModel_RestName>>();

		// Adding child data
		listDataHeader.add("Popular Cuisine");
		// listDataHeader.add("Favourite Restaurants");

		fetchCuisines();
		// fetchRestNames();

	}

	private void fetchCuisines() {

		cuisinelistDataChild.clear();

		RequestQueue queue = Volley.newRequestQueue(getActivity()
				.getApplicationContext());
		StringRequest sr = new StringRequest(Request.Method.GET,
				ConstantUrl.Url_main + ConstantUrl.Url_getcuisines,
				new Response.Listener<String>() {
					@Override
					public void onResponse(String response) {

						try {

							JSONObject json = new JSONObject(response);

							System.out.println("cuisine fetch response"	+ response);

							String msg = json.getString("message");

							System.out.println("message >>>>>>>>>" + msg);

							if (json.getString("code").equals("200")) {

								JSONArray jsonMainArr = json.getJSONArray("data");

								for (int j = 0; j < jsonMainArr.length(); j++) {

									FilterModel_Cuisine cuisineListModel = new FilterModel_Cuisine();

									JSONObject childJSONObject = jsonMainArr.getJSONObject(j);

									cuisineListModel.setfilter_cuisine(childJSONObject.getString("Cuisine_name"));
									cuisineListModel.setFilter_cuisine_id(childJSONObject.getString("cuisine_id"));
									cuisineListModel.setFilter_cuisine_status(childJSONObject.getString("cuisine_status"));

									favCuisine.add(cuisineListModel);

									System.out.println("cuisineListModel : "+ cuisineListModel);
									System.out.println("favCuisine : "+ favCuisine);

								}
								cuisinelistDataChild.put(listDataHeader.get(0), favCuisine);

								System.out.println("cuisinelistDataChild.size() === "
												+ cuisinelistDataChild.size());
								}
							
							else
							{
								Toast.makeText(
										getActivity().getApplicationContext(),
										msg, Toast.LENGTH_LONG).show();
							}

						} catch (Exception e) {
							e.printStackTrace();
						}

						FilterlistAdapter.notifyDataSetChanged();

					}

				}, new Response.ErrorListener() {
					@Override
					public void onErrorResponse(VolleyError error) {
						// VolleyLog.d(TAG, "Error: " + error.getMessage());
						System.out.println("Error : " + error);
						// hidePDialog();

					}
				});

		queue.add(sr);

	}

}
