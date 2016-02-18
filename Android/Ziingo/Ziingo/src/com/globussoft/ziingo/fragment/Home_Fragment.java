package com.globussoft.ziingo.fragment;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.globussoft.ziingo.R;

public class Home_Fragment extends Fragment 
{
	
	 @Override
	    public View onCreateView(LayoutInflater inflater, ViewGroup container,
	            Bundle savedInstanceState) 
	 {
	  
	        View rootView = inflater.inflate(R.layout.fragment_home, container, false);
	          
	        return rootView;
	    }
	
	
	
	/*

	View rootview;

	ViewPager ads_pager, new_arrival_pager, today_offer_pager, dealer_pager;
	ProgressBar progressBar1_ads, progressBar1_new_arrival_pager,
			progressBar_today_offer_pager, progressBar_dealer_pager;
	PageIndicator indicator_ads, indicator_new_arrival_pager,
			indicator_today_offer_pager, indicator_dealer_pager;

	public static ArrayList<Ads_Model> ads_list;
	ArrayList<New_Arrival_Model> newarrivalList;
	ArrayList<New_Arrival_Model> today_arraylist;
	ArrayList<Dealer_model> dealer_arrayList;
	RelativeLayout ad_layout;
	Ads_Adp ads_adp;
	NewArrival_Adp new_arrival_adp;
	Today_Offer_Adp today_offer_adp;
	Dealer_Adp dealer_adp;

	Handler handler = new Handler();

	Timer swipeAds = new Timer();
	Timer swipeTimernewarrival = new Timer();
	Timer swipeTimer_today = new Timer();
	Timer swipeTimer_dealer = new Timer();

	int ads_interval = 0;
	int current_page_newarrival = 0;
	int current_page_today = 0;
	int current_page_dealr = 0;

	FragmentManager fragmentmanager;

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {

		rootview = inflater.inflate(R.layout.home_fragment, container, false);
		fragmentmanager = getFragmentManager();

		ads_list = new ArrayList<Ads_Model>();
		newarrivalList = new ArrayList<New_Arrival_Model>();
		today_arraylist = new ArrayList<New_Arrival_Model>();
		dealer_arrayList = new ArrayList<Dealer_model>();
		ad_layout = (RelativeLayout) rootview
				.findViewById(R.id.addsviewpager_rlt);

		ads_pager = (ViewPager) rootview.findViewById(R.id.ads_pager);
		new_arrival_pager = (ViewPager) rootview
				.findViewById(R.id.new_arrival_pager);
		today_offer_pager = (ViewPager) rootview
				.findViewById(R.id.today_offer_pager);
		dealer_pager = (ViewPager) rootview.findViewById(R.id.dealer_pager);

		progressBar1_ads = (ProgressBar) rootview
				.findViewById(R.id.progressBar1_ads);
		progressBar1_new_arrival_pager = (ProgressBar) rootview
				.findViewById(R.id.progressBar1_new_arrival_pager);
		progressBar_today_offer_pager = (ProgressBar) rootview
				.findViewById(R.id.progressBar_today_offer_pager);
		progressBar_dealer_pager = (ProgressBar) rootview
				.findViewById(R.id.progressBar_dealer_pager);

		indicator_ads = (PageIndicator) rootview
				.findViewById(R.id.indicator_ads);
		indicator_new_arrival_pager = (PageIndicator) rootview
				.findViewById(R.id.indicator_new_arrival_pager);
		indicator_today_offer_pager = (PageIndicator) rootview
				.findViewById(R.id.indicator_today_offer_pager);
		indicator_dealer_pager = (PageIndicator) rootview
				.findViewById(R.id.indicator_dealer_pager);

		ads_adp = new Ads_Adp(getActivity(), ads_list, fragmentmanager);
		ads_pager.setAdapter(ads_adp);
		indicator_ads.setViewPager(ads_pager);

		new_arrival_adp = new NewArrival_Adp(getActivity(), newarrivalList,
				fragmentmanager);
		new_arrival_pager.setAdapter(new_arrival_adp);
		indicator_new_arrival_pager.setViewPager(new_arrival_pager);

		today_offer_adp = new Today_Offer_Adp(getActivity(), today_arraylist,
				fragmentmanager);
		today_offer_pager.setAdapter(today_offer_adp);
		indicator_today_offer_pager.setViewPager(today_offer_pager);

		dealer_adp = new Dealer_Adp(getActivity(), dealer_arrayList,
				getChildFragmentManager());
		dealer_pager.setAdapter(dealer_adp);
		indicator_dealer_pager.setViewPager(dealer_pager);

		dealer_pager.setOnTouchListener(new OnTouchListener() {

			@Override
			public boolean onTouch(View v, MotionEvent event) {

				if (swipeTimer_dealer != null) {
					swipeTimer_dealer.cancel();
				}

				return false;
			}
		});

		ads_pager.setOnTouchListener(new OnTouchListener() {

			@Override
			public boolean onTouch(View v, MotionEvent event) {

				if (swipeAds != null) {
					swipeAds.cancel();
				}

				return false;
			}
		});

		if (ConstantUrls.isNetworkAvailable(getActivity())) {
			new Fetch_Ads().execute();

			new Fetch_NewArrivals().execute();

			new Fetch_Today_offer().execute();

			new Fetch_Dealer_data().execute();

		} else {

			MainActivity.MakeToast("Please check internet connection!!");
		}

		swipeAds.schedule(new TimerTask() {

			@Override
			public void run() {

				handler.post(new Runnable() {

					public void run() {

						if (ads_interval == ads_list.size() - 1) {
							ads_interval = 0;
						}
						ads_pager.setCurrentItem(ads_interval++, true);
					}
				});
			}
		}, 100, 3000);

		
		 * swipeTimernewarrival.schedule(new TimerTask() {
		 * 
		 * @Override public void run() {
		 * 
		 * handler.post( new Runnable() {
		 * 
		 * public void run() {
		 * 
		 * if (current_page_newarrival == newarrivalList.size() - 1) {
		 * current_page_newarrival = 0; }
		 * new_arrival_pager.setCurrentItem(current_page_newarrival++, true); }
		 * }); } }, 100, 3000);
		 * 
		 * swipeTimer_today.schedule(new TimerTask() {
		 * 
		 * @Override public void run() {
		 * 
		 * handler.post( new Runnable() {
		 * 
		 * public void run() {
		 * 
		 * if (current_page_today == today_arraylist.size() - 1) {
		 * current_page_today = 0; }
		 * today_offer_pager.setCurrentItem(current_page_today++, true); } }); }
		 * }, 100, 2600);
		 

		swipeTimer_dealer.schedule(new TimerTask() {

			@Override
			public void run() {

				handler.post(new Runnable() {

					public void run() {

						if (current_page_dealr == dealer_arrayList.size() - 1) {
							current_page_dealr = 0;
						}
						dealer_pager.setCurrentItem(current_page_dealr++, true);
					}
				});
			}
		}, 100, 2500);

		return rootview;
	}

	class Fetch_Ads extends AsyncTask<String, Void, JSONObject> {
		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			progressBar1_ads.setVisibility(View.VISIBLE);
			ads_list.clear();

		}

		@Override
		protected JSONObject doInBackground(String... params) {

			JSONParser jsonParser = new JSONParser();

			List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();

			nameValuePairs.add(new BasicNameValuePair("mytoken",
					Singleton.mytoken));
			nameValuePairs.add(new BasicNameValuePair("user_id",
					Singleton.user_id));
			nameValuePairs.add(new BasicNameValuePair("ad_type", "2"));
			nameValuePairs.add(new BasicNameValuePair("city", Singleton.city));

			System.out.println("mytoken=" + Singleton.mytoken);
			System.out.println("user_id=" + Singleton.user_id);
			System.out.println("ad_type=" + "2");
			System.out.println("city=" + Singleton.city);

			return jsonParser.getJSONFromUrlByPost(ConstantUrls.UrlMain
					+ ConstantUrls.FetchAds, nameValuePairs);
		}

		@Override
		protected void onPostExecute(JSONObject result) {
			super.onPostExecute(result);

			progressBar1_ads.setVisibility(View.INVISIBLE);

			System.out.println("Fetch_Ads=" + result);

			if (result.has("code")) {
				try {

					if (result.getInt("code") == 200) {
						if (result.has("data")) {
							try {
								JSONArray jsonArray = result
										.getJSONArray("data");

								if (jsonArray.length() != 0) {
									for (int i = 0; i < jsonArray.length(); i++) {
										Ads_Model ads_Model = new Ads_Model();

										JSONObject jsonObject = jsonArray
												.getJSONObject(i);

										ads_Model.setAd_id(jsonObject
												.getString("ad_id"));
										ads_Model.setAd_image_url(jsonObject
												.getString("ad_image_url"));
										ads_Model.setAd_subject(jsonObject
												.getString("ad_subject"));
										ads_Model.setAd_description(jsonObject
												.getString("ad_description"));
										ads_Model.setAd_status(jsonObject
												.getString("ad_status"));
										ads_Model.setAd_location_ids(jsonObject
												.getString("ad_location_ids"));
										ads_Model.setAd_website_url(jsonObject
												.getString("ad_website_url"));
										ads_Model.setAd_type(jsonObject
												.getString("ad_type"));
										ads_Model.setLoc_details(jsonObject
												.getString("loc_details"));

										System.out
												.println(">>>>>>>>>>>>>>>"
														+ jsonObject
																.getString("ad_image_url"));

										ads_list.add(ads_Model);
									}

								}

								ads_adp.notifyDataSetChanged();

								if (Singleton.listner != null) {
									Singleton.listner.showadds();
								}
							} catch (Exception e) {

							}
						}

					} else {
						ad_layout.setVisibility(View.GONE);
					}

				} catch (JSONException e) {
					e.printStackTrace();
				}

			} else {
				System.out.println("ERERERER");
			}
		}

	}

	class Fetch_NewArrivals extends AsyncTask<String, Void, JSONObject> {
		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			progressBar1_new_arrival_pager.setVisibility(View.VISIBLE);
			newarrivalList.clear();
		}

		@Override
		protected JSONObject doInBackground(String... params) {

			JSONParser jsonParser = new JSONParser();

			List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();

			nameValuePairs.add(new BasicNameValuePair("mytoken",
					Singleton.mytoken));

			return jsonParser.getJSONFromUrlByPost(ConstantUrls.UrlMain
					+ ConstantUrls.newArrivals, nameValuePairs);
		}

		@Override
		protected void onPostExecute(JSONObject result) {
			super.onPostExecute(result);

			progressBar1_new_arrival_pager.setVisibility(View.INVISIBLE);

			System.out.println("NEW ARRIVAL=" + result);

			if (result.has("code")) {
				try {

					if (result.getInt("code") == 200) {
						if (result.has("data")) {
							try {
								JSONArray jsonArray = result
										.getJSONArray("data");

								if (jsonArray.length() != 0) {
									for (int i = 0; i < jsonArray.length(); i++) {
										New_Arrival_Model arrival_Model = new New_Arrival_Model();

										JSONObject jsonObject = jsonArray
												.getJSONObject(i);

										arrival_Model.setProduct_id(jsonObject
												.getString("product_id"));
										arrival_Model
												.setProduct_name(jsonObject
														.getString("product_name"));
										arrival_Model
												.setProduct_status(jsonObject
														.getString("product_status"));
										arrival_Model
												.setDiscount_value(jsonObject
														.getString("discount_value"));
										arrival_Model
												.setDiscount_from_date(jsonObject
														.getString("discount_to_date"));
										arrival_Model
												.setDiscount_type(jsonObject
														.getString("discount_type"));
										arrival_Model.setImage_url(jsonObject
												.getString("image_url"));
										arrival_Model
												.setDiscountflag(jsonObject
														.getString("discountflag"));

										newarrivalList.add(arrival_Model);
									}

								}

								new_arrival_adp.notifyDataSetChanged();
							} catch (Exception e) {

							}
						}

					}
				} catch (JSONException e) {
					e.printStackTrace();
				}

			} else {
				System.out.println("ERERERER");
			}
		}

	}

	class Fetch_Today_offer extends AsyncTask<String, Void, JSONObject> {
		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			progressBar_today_offer_pager.setVisibility(View.VISIBLE);
			today_arraylist.clear();
		}

		@Override
		protected JSONObject doInBackground(String... params) {

			JSONParser jsonParser = new JSONParser();

			List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();

			nameValuePairs.add(new BasicNameValuePair("mytoken",
					Singleton.mytoken));

			return jsonParser.getJSONFromUrlByPost(ConstantUrls.UrlMain
					+ ConstantUrls.TodayOffer, nameValuePairs);
		}

		@Override
		protected void onPostExecute(JSONObject result) {
			super.onPostExecute(result);

			progressBar_today_offer_pager.setVisibility(View.INVISIBLE);

			System.out.println("NEW ARRIVAL=" + result);

			if (result.has("code")) {
				try {

					if (result.getInt("code") == 200) {
						if (result.has("data")) {
							try {
								JSONArray jsonArray = result
										.getJSONArray("data");

								if (jsonArray.length() != 0) {
									for (int i = 0; i < jsonArray.length(); i++) {
										New_Arrival_Model arrival_Model = new New_Arrival_Model();

										JSONObject jsonObject = jsonArray
												.getJSONObject(i);

										arrival_Model.setProduct_id(jsonObject
												.getString("product_id"));
										arrival_Model
												.setProduct_name(jsonObject
														.getString("product_name"));
										arrival_Model
												.setProduct_status(jsonObject
														.getString("product_status"));
										arrival_Model
												.setDiscount_value(jsonObject
														.getString("discount_value"));
										arrival_Model
												.setDiscount_from_date(jsonObject
														.getString("discount_to_date"));
										arrival_Model
												.setDiscount_type(jsonObject
														.getString("discount_type"));
										arrival_Model.setImage_url(jsonObject
												.getString("image_url"));

										today_arraylist.add(arrival_Model);
									}

								}

								today_offer_adp.notifyDataSetChanged();
							} catch (Exception e) {

							}
						}

					}
				} catch (JSONException e) {
					e.printStackTrace();
				}

			} else {
				System.out.println("ERERERER");
			}
		}

	}

	class Fetch_Dealer_data extends AsyncTask<String, Void, JSONObject> {

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			progressBar_dealer_pager.setVisibility(View.VISIBLE);
			dealer_arrayList.clear();

		}

		@Override
		protected JSONObject doInBackground(String... params) {

			JSONParser jsonParser = new JSONParser();

			List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();

			nameValuePairs.add(new BasicNameValuePair("mytoken",
					Singleton.mytoken));
			nameValuePairs.add(new BasicNameValuePair("user_id",
					Singleton.user_id));
			nameValuePairs.add(new BasicNameValuePair("count", "25"));
			nameValuePairs.add(new BasicNameValuePair("offset", "0"));

			return jsonParser.getJSONFromUrlByPost(ConstantUrls.UrlMain
					+ ConstantUrls.Dealers, nameValuePairs);
		}

		@Override
		protected void onPostExecute(JSONObject result) {
			super.onPostExecute(result);
			progressBar_dealer_pager.setVisibility(View.INVISIBLE);

			System.out.println("result dealer=" + result);

			if (result.has("code")) {
				try {

					if (result.getInt("code") == 200) {
						if (result.has("data")) {
							try {

								JSONArray jsonArray = result
										.getJSONArray("data");
								System.out.println("jsonArray.length()="
										+ jsonArray.length());
								if (jsonArray.length() != 0) {
									for (int i = 0; i < jsonArray.length(); i++) {
										JSONObject jsonObject = jsonArray
												.getJSONObject(i);

										Dealer_model dealer_model = new Dealer_model();

										dealer_model.setStore_id(jsonObject
												.getString("store_id"));
										dealer_model.setStore_name(jsonObject
												.getString("store_name"));
										dealer_model.setSku(jsonObject
												.getString("sku"));
										dealer_model.setMerchant_id(jsonObject
												.getString("merchant_id"));
										dealer_model
												.setStore_banner_url(jsonObject
														.getString("store_banner_url"));
										dealer_model.setStore_rating(jsonObject
												.getString("store_rating"));
										dealer_model
												.setStore_followers_count(jsonObject
														.getString("store_followers_count"));
										dealer_model.setStore_status(jsonObject
												.getString("store_status"));
										dealer_model
												.setCod_availability(jsonObject
														.getString("cod_availability"));
										dealer_model
												.setStore_metadata_id(jsonObject
														.getString("store_metadata_id"));
										dealer_model.setStore_type(jsonObject
												.getString("store_type"));
										dealer_model
												.setAddress_line_1(jsonObject
														.getString("address_line_1"));
										dealer_model
												.setAddress_line_2(jsonObject
														.getString("address_line_2"));
										dealer_model.setCity(jsonObject
												.getString("city"));
										dealer_model.setState(jsonObject
												.getString("state"));
										dealer_model.setCountry_id(jsonObject
												.getString("country_id"));
										dealer_model.setZip_code(jsonObject
												.getString("zip_code"));
										dealer_model.setLatitude(jsonObject
												.getString("latitude"));
										dealer_model.setLongitude(jsonObject
												.getString("longitude"));
										dealer_model.setAdded_date(jsonObject
												.getString("added_date"));
										dealer_model
												.setSmd_status_set_by(jsonObject
														.getString("smd_status_set_by"));
										dealer_model
												.setStore_metadata_status(jsonObject
														.getString("store_metadata_status"));

										dealer_arrayList.add(dealer_model);
									}

									dealer_adp.notifyDataSetChanged();
								}
							} catch (Exception e) {
								e.printStackTrace();
							}

						}

					} else {

					}
				} catch (JSONException e) {
					e.printStackTrace();
				}

			} else {

			}
		}

	}

*/}
